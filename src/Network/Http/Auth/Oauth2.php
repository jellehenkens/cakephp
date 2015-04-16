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
namespace Cake\Network\Http\Auth;

use Cake\Core\Exception\Exception;
use Cake\Network\Http\Request;

/**
 * Oauth 2 authentication strategy for Cake\Network\Http\Client
 *
 * This object does not handle getting Oauth2 access tokens from the service
 * provider. It only handles make client requests *after* you have obtained the Oauth
 * tokens.
 *
 * Generally not directly constructed, but instead used by Cake\Network\Http\Client
 * when $options['auth']['type'] is 'oauth'
 */
class Oauth2
{

    /**
     * Add headers for Oauth2 authorization. Currently only the Bearer
     * token type is supported.
     *
     * @param \Cake\Network\Http\Request $request The request object.
     * @param array $credentials Authentication credentials.
     * @return void
     * @throws \Cake\Core\Exception\Exception On invalid method.
     * @see http://www.ietf.org/rfc/rfc2617.txt
     */
    public function authentication(Request $request, array $credentials)
    {
        if (!isset($credentials['accessToken'])) {
            return false;
        }

        if (empty($credentials['method'])) {
            $credentials['method'] = 'header';
        }
        $credentials['method'] = strtolower($credentials['method']);
        switch ($credentials['method']) {
            case 'header':
                $this->_header($request, $credentials['accessToken']);
                break;

            case 'body':

                break;

            case 'query':

                break;

            default:
                throw new Exception(sprintf('Unknown request method %s', $credentials['method']));
        }

    }

    /**
     * Add the bearer token as Authorization header to the request.
     *
     * @param \Cake\Network\Http\Request $request The request object.
     * @param string $accessToken The bearer access token.
     * @return void
     * @see https://tools.ietf.org/html/rfc6750#section-2.1
     */
    protected function _header($request, $accessToken)
    {
        $request->header('Authorization', 'Bearer ' . $accessToken);
    }

    /**
     * Add the bearer token as form-encoded body parameter to the request.
     *
     * @param \Cake\Network\Http\Request $request The request object.
     * @param string $accessToken The bearer access token.
     * @return void
     * @see https://tools.ietf.org/html/rfc6750#section-2.2
     */
    protected function _body($request, $accessToken)
    {

    }
}
