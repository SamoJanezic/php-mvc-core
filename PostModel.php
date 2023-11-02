<?php

namespace samojanezic\phpmvc;

use samojanezic\phpmvc\db\DbModel;


abstract class PostModel extends DbModel
{
    abstract public function greet(): string;
}