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

class User
{
    /** @var array */
    private $userData;

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    public function getId(): string
    {
        return $this->userData["id_str"];
    }
}
