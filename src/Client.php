<?php

namespace SdV\Ibp;

use GuzzleHttp\Client as HttpClient;

class Client
{
    use MakesHttpRequests,
        Actions\ManagesApplications,
        Actions\ManagesAuthentication,
        Actions\ManagesFiles,
        Actions\ManagesFolders,
        Actions\ManagesMethodes,
        Actions\ManagesPipelines,
        Actions\ManagesUploads,
        Actions\ManagesSearch;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @param string     $baseUri
     * @param HttpClient $client
     */
    protected $client;

    /**
     * The IBP base URI
     * @var string
     */
    protected $baseUri;

    public function __construct($baseUri, HttpClient $client = null)
    {
        $this->baseUri = $baseUri;

        $this->client = $client ?: new HttpClient([
            'base_uri' => $baseUri,
            'http_errors' => false,
        ]);
    }

    /**
     * Transforme une réponse IBP contenant une liste de models en array.
     *
     * @param  Resource $class
     * @param  array $data
     * @return array
     */
    protected function mapToCollectionOf($class, $data)
    {
        return array_map(function ($attributes) use ($class) {
            return new $class($attributes);
        }, $data);
    }
}
