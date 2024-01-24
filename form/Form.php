<?php

namespace samojanezic\phpmvc\form;
use samojanezic\phpmvc\Model;
use samojanezic\phpmvc\form\InputField;

class Form
{
  public static function begin($action, $method, $attribute = '')
  {
    echo sprintf('<form action="%s" method="%s" %s>', $action, $method, $attribute);
    return new Form();
  }

  public static function end()
  {
    echo '</form>';
  }

  public function field(Model $model, $attribute)
  {
    return new InputField($model, $attribute);
  }
}
