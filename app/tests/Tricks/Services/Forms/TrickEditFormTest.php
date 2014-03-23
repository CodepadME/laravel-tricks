<?php

namespace Tricks\Services\Forms;

use Mockery;
use TestCase;

class TrickEditFormTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/services
   */
  public function testConstructor()
  {
    $trickEditForm = new TrickEditForm(1);

    $this->assertEquals(
      1,
      $this->getProtectedProperty($trickEditForm, 'id')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetPreparedRules()
  {
    $trickEditFormMock = Mockery::mock('Tricks\Services\Forms\TrickEditForm', [
      1
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $before = $this->getProtectedProperty($trickEditFormMock, 'rules');

    $after = $before;
    $after["title"] .= ',1';

    $this->assertEquals(
      $after,
      $trickEditFormMock->getPreparedRules()
    );
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

    $trickEditForm = new TrickEditForm(1);

    $this->setProtectedProperty($trickEditForm, 'inputData', $before);

    $this->assertEquals(
      array_keys($after),
      array_keys($trickEditForm->getInputData())
    );
  }
}
