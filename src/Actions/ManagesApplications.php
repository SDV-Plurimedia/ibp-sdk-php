<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\Application;

trait ManagesApplications
{
    /**
     * Renvoie la liste des applications.
     *
     * @return Application[]
     */
    public function applications(array $query = [])
    {
        $response = $this->get('applications', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(Application::class, $response['data']),
            $response['meta']
        );
    }

    /**
     * Renvoie une application.
     *
     * @param  string $applicationId
     * @return Application
     */
    public function application($applicationId)
    {
        return new Application($this->get("applications/$applicationId")['data']);
    }

    /**
     * Crée une nouvelle application.
     *
     * @param  string $name Le nom de l'application
     * @param  string $description La description de l'application.
     * @return Application
     */
    public function createApplication($name, $description)
    {
        return new Application($this->post("applications", [
            'name' => $name,
            'description' => $description,
        ])['data']);
    }

    /**
     * Crée une nouvelle application.
     *
     * @param  string $applicationId L'identifiant de l'application à supprimer.
     * @param  string $name Le nom de l'application
     * @param  string $description La description de l'application.
     * @return Application
     */
    public function updateApplication($applicationId, $name, $description)
    {
        return new Application($this->put("applications/$applicationId", [
            'name' => $name,
            'description' => $description,
        ])['data']);
    }

    /**
     * Supprimer une application.
     *
     * @param  string $applicationId L'identifiant de l'application à supprimer.
     * @return boolean|Exception
     */
    public function deleteApplication($applicationId)
    {
        $this->delete("applications/$applicationId");

        return true;
    }
}
