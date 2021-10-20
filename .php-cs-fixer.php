<?php
use Ergebnis\PhpCsFixer\Config;

$config = Config\Factory::fromRuleSet(new Config\RuleSet\Php80(), [
    'final_class' => false
]);

$config->getFinder()->in(__DIR__);
$config->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');

return $config;
