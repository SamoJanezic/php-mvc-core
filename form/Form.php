<?php

namespace samojanezic\phpmvc\form;
use samojanezic\phpmvc\Model;
use samojanezic\phpmvc\form\InputField;

class Form
{
  public static function begin($action, $method)
  {
    echo sprintf('<form action="%s" method="%s">', $action, $method);
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
