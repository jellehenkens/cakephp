<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\Network\Http\Auth;

use Cake\Network\Http\Auth\Oauth2;
use Cake\Network\Http\Request;
use Cake\TestSuite\TestCase;

/**
 * Oauth test.
 */
class Oauth2Test extends TestCase
{

    /**
     * @expectedException \Cake\Core\Exception\Exception
     */
    public function testExceptionUnknownMethod()
    {
        $auth = new Oauth2();
        $creds = [
            'accessToken' => 'a key',
            'method' => 'magic'
        ];
        $request = new Request();
        $auth->authentication($request, $creds);
    }

    /**
     * testAuthorizationHeaderMethod method
     *
     * @return void
     */
    public function testAuthorizationHeaderMethod()
    {
        $auth = new Oauth2();
        $creds = [
            'accessToken' => 'the-crystal-key',
            'method' => 'header',
        ];
        $request = new Request();
        $auth->authentication($request, $creds);

        $result = $request->header('Authorization');
        $this->assertEquals('Bearer the-crystal-key', $result);
    }
}
