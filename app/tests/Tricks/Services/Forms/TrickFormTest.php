<?php

namespace Tricks\Services\Forms;

use Mockery;
use TestCase;

class TrickFormTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/services
   */
  public function testGetInputData()
  {
    $before = [
      'title'       => 'foo',
      'description' => 'bar',
      'tags'        => '1,2,3',
      'categories'  => '1,2,3',
      'code'        => 'baz',
      'invalid'     => 'YOU SHALL NOT PASS'
    ];

    $after = [
      'title'       => 'foo',
      'description' => 'bar',
      'tags'        => '1,2,3',
      'categories'  => '1,2,3',
      'code'        => 'baz'
    ];

    $tricksForm = new TrickForm();

    $this->setProtectedProperty($tricksForm, 'inputData', $before);

    $this->assertEquals(
      array_keys($after),
      array_keys($tricksForm->getInputData())
    );
  }
}
