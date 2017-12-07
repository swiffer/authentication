<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Authentication\Test\TestCase\Authenticator;

use Authentication\Authenticator\LoginUrlChecker;
use Authentication\Test\TestCase\AuthenticationTestCase as TestCase;
use Cake\Http\ServerRequestFactory;

/**
 * LoginUrlCheckerTest
 */
class LoginUrlCheckerTest extends TestCase
{

    /**
     * testCheck
     *
     * @return void
     */
    public function testCheck()
    {
        $checker = new LoginUrlChecker();

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/does-not-match'],
            []
        );

        $result = $checker->check($request, '/users/login');
        $this->assertFalse($result);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/login'],
            []
        );
        $result = $checker->check($request, '/users/login');
        $this->assertTrue($result);

        $result = $checker->check($request, [
            '/users/login',
            '/admin/login'
        ]);
        $this->assertTrue($result);
    }
}
