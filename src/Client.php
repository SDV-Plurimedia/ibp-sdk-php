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

    protected string $baseUri;

    public function __construct($baseUri, protected ?HttpClient $client = null)
    {
        $this->baseUri = $baseUri;

        $this->client = $client ?: new HttpClient([
            'base_uri' => $baseUri,
            'http_errors' => false,
        ]);
    }

    /**
     * Transforme une réponse IBP contenant une liste de models en array.
     * @param  array $data
     * @return array
     */
    protected function mapToCollectionOf(string $class, array $data): array
    {
        return array_map(function (array $attributes) use ($class) {
            return new $class($attributes);
        }, $data);
    }
}
