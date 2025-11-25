<?php

namespace SdV\Ibp\Actions;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use SdV\Ibp\Client;

trait ManagesAuthentication
{
    /**
     * The application Id
     */
    private string $applicationId;

    /**
     * The application Secret
     */
    private string $applicationSecret;

    /**
     * The application Token
     */
    private string $applicationToken;

    /**
     * The upload Token
     */
    private string $uploadToken;

    /**
     * Initialiase un application Token.
     */
    public function setApplicationId(string $applicationId): Client
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    /**
     * Initialiase un application secret.
     */
    public function setApplicationSecret(string $applicationSecret): Client
    {
        $this->applicationSecret = $applicationSecret;

        return $this;
    }

    /**
     * Initialiase un application Token.
     */
    public function setApplicationToken(string $token): Client
    {
        $this->applicationToken = $token;

        return $this;
    }

    /**
     * Initialiase un upload Token.
     */
    public function setUploadToken(string $token): Client
    {
        $this->uploadToken = $token;

        return $this;
    }

    /**
     * Génération d'un token d'upload.
     * @param  string  $email
     * @param  string  $audience The audience value is a string -- typically, the base address of the resource being accessed, such as "https://ibp.xxx.fr".
     * @param  integer $lifetime La durée de vie du token.
     * @return string
     */
    public function uploadToken(string $email, int $lifetime = 120): string
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->applicationSecret)
        );

        $now = new \DateTimeImmutable();

        $token = $config
            ->builder()
            ->issuedBy($this->applicationId)
            ->permittedFor($this->baseUri)
            ->identifiedBy(sha1(time() . bin2hex(random_bytes(5))))
            ->issuedAt($now->modify('-2 seconds'))
            ->canOnlyBeUsedAfter($now->modify('-2 seconds'))
            ->expiresAt($now->modify('+' . $lifetime . ' seconds'))
            ->relatedTo($this->applicationId)
            ->withClaim('application_id', $this->applicationId)
            ->withClaim('email', $email)
            ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }

    /**
     * Génération d'un token d'application.
     * @param  integer $lifetime La durée de vie du token.
     */
    public function applicationToken(int $lifetime = 120): string
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->applicationSecret)
        );

        $now = new \DateTimeImmutable();

        $token = $config
            ->builder()
            ->issuedBy($this->applicationId)
            ->permittedFor($this->baseUri)
            ->identifiedBy(sha1(time() . bin2hex(random_bytes(5))))
            ->issuedAt($now->modify('-2 seconds'))
            ->canOnlyBeUsedAfter($now->modify('-2 seconds'))
            ->expiresAt($now->modify('+' . $lifetime . ' seconds'))
            ->relatedTo($this->applicationId)
            ->withClaim('application_id', $this->applicationId)
            ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }
}
