<?php
namespace Segura\AppCore\Interfaces;

interface ModelInterface
{
    public static function factory();

    public function save();

    public function destroy();

    public function destroyThoroughly();

    public function getListOfProperties();
}
