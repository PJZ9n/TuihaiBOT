<?php

/**
 * Copyright (c) 2020 PJZ9n.
 *
 * This file is part of TwihaiBOT.
 *
 * TwihaiBOT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TwihaiBOT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TwihaiBOT. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace PJZ9n\TwihaiBot;

class FollowerLookup
{
    /** @var array */
    private $lookupData;

    public function __construct(array $lookupData)
    {
        $this->lookupData = $lookupData;
    }

    public function getId(): string
    {
        return $this->lookupData["id_str"];
    }

    public function isFollowing(): bool
    {
        return in_array("following", $this->lookupData["connections"], true);
    }

    public function isFollowRequesting(): bool
    {
        return in_array("following_requested", $this->lookupData["connections"], true);
    }
}
