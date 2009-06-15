<?php

require(dirname(__FILE__).'/../../bootstrap/unit.php');

$t = new lime_test(14, new lime_output_color());

$request = new sfTwitterRequest();

$t->diag('->getResponseFormat()');
$t->isa_ok($request->getResponseFormat(), 'string', '->getResponseFormat() returns a string value');

$request = new sfTwitterRequest();
$request->setResponseFormat('xml');
$t->is($request->getResponseFormat(), 'xml', '->getResponseFormat() returns "xml"');

$request = new sfTwitterRequest();
$request->setResponseFormat('json');
$t->is($request->getResponseFormat(), 'json', '->getResponseFormat() returns "json"');

$request = new sfTwitterRequest();
$request->setResponseFormat('atom');
$t->is($request->getResponseFormat(), 'atom', '->getResponseFormat() returns "atom"');

$request = new sfTwitterRequest();
$request->setResponseFormat('rss');
$t->is($request->getResponseFormat(), 'rss', '->getResponseFormat() returns "rss"');

try
{
  $request = new sfTwitterRequest();
  $request->setResponseFormat('foo');
  $t->fail('->setResponseFormat() must throw an exception');
}
catch (Exception $e)
{
  $t->pass('->setResponseFormat() threw an exception for invalid format "foo"');
}

$t->diag('->getMethod()');
$t->isa_ok($request->getMethod(), 'string', '->getMethod() returns a string value');

$request = new sfTwitterRequest();
$request->setMethod('get');
$t->is($request->getMethod(), 'get', '->getMethod() returns "get"');

$request = new sfTwitterRequest();
$request->setMethod('post');
$t->is($request->getMethod(), 'post', '->getMethod() returns "post"');

$request = new sfTwitterRequest();
$request->setMethod('delete');
$t->is($request->getMethod(), 'delete', '->getMethod() returns "delete"');

try
{
  $request = new sfTwitterRequest();
  $request->setMethod('foo');
  $t->fail('->setMethod() must throw an exception');
}
catch (Exception $e)
{
  $t->pass('->setMethod() threw an exception for invalid method "foo"');
}

$t->diag('->isMethod()');
$request = new sfTwitterRequest();
$t->isa_ok($request->isMethod('get'), 'boolean', '->isMethod() returns a boolean value');
$t->is($request->isMethod('get'), true, '->isMethod() returns "true"');
$request->setMethod('post');
$t->is($request->isMethod('get'), false, '->isMethod() returns "false"');
