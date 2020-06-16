<?php

/**
 * Copyright (c) 2020 PJZ9n.
 *
 * This file is part of TuihaiBOT.
 *
 * TuihaiBOT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TuihaiBOT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TuihaiBOT. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace PJZ9n\TuihaiBot;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

require_once __DIR__ . "/../../../vendor/autoload.php";

abstract class AppLog
{
    public static function get(): Logger
    {
        $logger = new Logger("AppLogger");
        $logger->pushHandler(new RotatingFileHandler(__DIR__ . "/../../../logs/app-development.log", 0, Logger::DEBUG));
        $logger->pushHandler(new RotatingFileHandler(__DIR__ . "/../../../logs/app-production.log", 0, Logger::INFO));
        $logger->pushHandler(new RotatingFileHandler(__DIR__ . "/../../../logs/app-error.log", 0, Logger::NOTICE));
        return $logger;
    }
}
