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

use Abraham\TwitterOAuth\TwitterOAuth;

class UserAPI
{
    /** @var TwitterOAuth */
    private $oauthUser;

    public function __construct(string $token, string $tokenSecret)
    {
        $this->oauthUser = new TwitterOAuth(
            $_ENV["CONSUMER_KEY"],
            $_ENV["CONSUMER_KEY_SECRET"],
            $token,
            $tokenSecret
        );
        $this->oauthUser->setDecodeJsonAsArray(true);
    }

    /**
     * APIのステータスコードをチェックする
     * TODO: 再利用できるようにする
     *
     * @param int $expect 期待されるステータスコード
     *
     * @return bool 成功したか
     */
    public function checkStatusCode(int $expect): bool
    {
        if ($this->oauthUser->getLastHttpCode() === $expect) {
            return true;
        }
        $lastBody = $this->oauthUser->getLastBody();
        $body = $lastBody["errors"] ?? base64_encode(serialize($lastBody));
        AppLog::get()->error("The status code returned by the API is invalid.", [
            "Except" => $expect,
            "HttpCode" => $this->oauthUser->getLastHttpCode(),
            "ApiPath" => $this->oauthUser->getLastApiPath(),
            "Body" => $body,
        ]);
        return false;
    }

    /**
     * APIのステータスコードをチェックして、異常だったら例外を投げる
     *
     * @param int $except 期待されるステータスコード
     *
     * @throws APIException
     */
    public function checkStatusCodeFatal(int $except): void
    {
        if (!$this->checkStatusCode($except)) {
            throw new APIException("The status code returned by the API is invalid.");
        }
    }

    /**
     * @return User[]
     *
     * @throws APIException
     */
    public function getFollowers(): array
    {
        $rawFollowers = $this->oauthUser->get("followers/list", [
            "count" => 200,
        ]);
        $this->checkStatusCodeFatal(200);
        $followers = [];
        foreach ($rawFollowers["users"] as $rawFollower) {
            $followers[] = new User($rawFollower);
        }
        return $followers;
    }

    /**
     * @param User[] $users
     *
     * @return FollowerLookup[]
     *
     * @throws APIException
     */
    public function getFollowerLookup(User ...$users): array
    {
        $rawFollowerLookup = $this->oauthUser->get("friendships/lookup", [
            "user_id" => implode(",", array_map(function (User $value): string {
                return $value->getId();
            }, $users)),
        ]);
        $this->checkStatusCodeFatal(200);
        $followerLookup = [];
        foreach ($rawFollowerLookup as $value) {
            $followerLookup[] = new FollowerLookup($value);
        }
        return $followerLookup;
    }

    /**
     * ユーザーをフォローする
     *
     * @param string $userId
     */
    public function follow(string $userId): bool
    {
        $this->oauthUser->post("friendships/create", [
            "user_id" => $userId,
        ]);
        return $this->checkStatusCode(200);
    }
}
