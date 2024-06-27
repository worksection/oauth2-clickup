<?php

namespace Worksection\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class ClickUp extends AbstractProvider
{
  const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'id';

  /**
   * Constructs an OAuth 2.0 service provider.
   *
   * @param array $options An array of options to set on this provider.
   *     Options include `clientId`, `clientSecret`, `redirectUri`, and `state`.
   *     Individual providers may introduce more options, as needed.
   */
  public function __construct(array $options = [])
  {
    parent::__construct($options, []);
  }

  public function getBaseAuthorizationUrl()
  {
    return 'https://app.clickup.com/api';
  }

  public function getBaseAccessTokenUrl(array $params)
  {
    return 'https://api.clickup.com/api/v2/oauth/token';
  }

  public function getDefaultScopes()
  {
    return [];
  }

  public function checkResponse(ResponseInterface $response, $data)
  {
    if (!empty($data['errors'])) {
      throw new IdentityProviderException($data['errors'], 0, $data);
    }

    return $data;
  }

  protected function createResourceOwner(array $response, AccessToken $token)
  {
    return new CkickUpUser($response);
  }

  public function getResourceOwnerDetailsUrl(AccessToken $token)
  {
	return 'https://api.clickup.com/api/v2/user';
  }
}
