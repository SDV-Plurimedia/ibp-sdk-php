<?php

namespace SdV\Ibp\Actions;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

trait ManagesAuthentication
{
    /**
     * The application Id
     * @var string
     */
    private $applicationId;

    /**
     * The application Secret
     * @var string
     */
    private $applicationSecret;

    /**
     * The application Token
     * @var string
     */
    private $applicationToken;

    /**
     * The upload Token
     * @var string
     */
    private $uploadToken;

    /**
     * Initialiase un application Token.
     *
     * @param string $applicationId
     * @return Ibp
     */
    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    /**
     * Initialiase un application secret.
     *
     * @param string $applicationSecret
     * @return Ibp
     */
    public function setApplicationSecret($applicationSecret)
    {
        $this->applicationSecret = $applicationSecret;

        return $this;
    }

    /**
     * Initialiase un application Token.
     *
     * @param string $token
     * @return Ibp
     */
    public function setApplicationToken($token)
    {
        $this->applicationToken = $token;

        return $this;
    }

    /**
     * Initialiase un upload Token.
     *
     * @param string $token
     * @return Ibp
     */
    public function setUploadToken($token)
    {
        $this->uploadToken = $token;

        return $this;
    }

    /**
     * Génération d'un token d'upload.
     *
     *
     * @param  string  $email
     * @param  string  $audience The audience value is a string -- typically, the base address of the resource being accessed, such as "https://ibp.xxx.fr".
     * @param  integer $lifetime La durée de vie du token.
     * @return string
     */
    public function uploadToken($email, $lifetime = 120)
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
     *
     * @param  integer $lifetime La durée de vie du token.
     * @return string
     */
    public function applicationToken($lifetime = 120)
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
