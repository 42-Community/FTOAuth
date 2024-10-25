<?php

// Reference
// https://www.mediawiki.org/wiki/Extension:WSOAuth/For_developers

namespace WSOAuth\AuthenticationProvider;

use MediaWiki\User\UserIdentity;
use Mehdibo\OAuth2\Client\Provider\FortyTwo;

// Implementation inspired by:
// https://gerrit.wikimedia.org/r/plugins/gitiles/mediawiki/extensions/WSOAuth/+/refs/heads/master/src/AuthenticationProvider/FacebookAuth.php
class FTAuthProvider extends AuthProvider {

	/**
	 * @var ForyTwo
	 */
	private $provider;

	/**
	 * @inheritDoc
	 */
	public function __construct(
		string $clientId,
		string $clientSecret,
		?string $authUri,
		?string $redirectUri
	) {
		$this->provider = new FortyTwo( [
			'clientId' => $clientId,
			'clientSecret' => $clientSecret,
			'redirectUri' => $redirectUri
		] );
	}

	/**
	 * @inheritDoc
	 */
	public function login(
		?string &$key,
		?string &$secret,
		?string &$authUrl
	): bool {
		$authUrl = $this->provider->getAuthorizationUrl( [
			'scope' => [ 'public' ]
		] );

		$secret = $this->provider->getState();

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function logout( UserIdentity &$user ): void {
	}

	/**
	 * @inheritDoc
	 */
	public function getUser(
		string $key,
		string $secret,
		&$errorMessage
	) {
		if ( !isset( $_GET['code'] ) ) {
			return false;
		}
		if ( !isset( $_GET['state'] ) || empty( $_GET['state'] ) || ( $_GET['state'] !== $secret ) ) {
			return false;
		}
		try {
			$token = $this->provider->getAccessToken( 'authorization_code', [ 'code' => $_GET['code'] ] );
			$user = $this->provider->getResourceOwner( $token );
			return [
				'name' => $user->getId(),
				'realname' => $user->getName(),
				'email' => $user->getEmail()
			];
		} catch ( \Exception $e ) {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function saveExtraAttributes( int $id ): void {
	}
}
