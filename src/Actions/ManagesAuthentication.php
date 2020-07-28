<?php

namespace SdV\Ibp\Actions;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use SdV\Ibp\Resources\Folder;

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
        $time = time();

        $token = (new Builder())
            ->setIssuer($this->applicationId)
            ->setAudience($this->baseUri)
            ->setId(sha1($time . bin2hex(random_bytes(5))), true)
            ->setIssuedAt($time)
            ->setNotBefore($time)
            ->setExpiration($time + $lifetime)
            ->set('sub', $this->applicationId)
            ->set('application_id', $this->applicationId)
            ->set('email', $email)
            ->sign(new Sha256(), $this->applicationSecret)
            ->getToken();

        return (string) $token;
    }

    /**
     * Génération d'un token d'application.
     *
     * @param  integer $lifetime La durée de vie du token.
     * @return string
     */
    public function applicationToken($lifetime = 120)
    {
        $time = time();

        $token = (new Builder())
            ->setIssuer($this->applicationId)
            ->setAudience($this->baseUri) // The audience value is a string -- typically, the base address of the resource being accessed, such as "https://ibp.xxx.fr".
            ->setId(sha1($time . bin2hex(random_bytes(5))), true)
            ->setIssuedAt($time)
            ->setNotBefore($time)
            ->setExpiration($time + $lifetime)
            ->set('sub', $this->applicationId)
            ->set('application_id', $this->applicationId)
            ->sign(new Sha256(), $this->applicationSecret)
            ->getToken();

        return (string) $token;
    }
}
