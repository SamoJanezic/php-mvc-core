<?php

namespace samojanezic\phpmvc;

use samojanezic\phpmvc\db\DbModel;


abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}