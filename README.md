# IBP API Client

A PHP client for the IBP API.

## Index

- [Installation](#installation)
- [Usage](#usage)
- [Authentication](#authentication)
- [Folders](#folders)
- [Files](#files)
- [Application](#application)
- [Methodes](#methodes)
- [Pipelines](#pipelines)

## Installation

Installing via composer

```
composer require sdv/ibp-sdk-php
```

## Usage

```
use SdV\Ibp;

$ibp = new Ibp('API_BASE_URL');
```

### Exceptions

```
try {
    $folders = $ibp->setApplicationId('APPLICATION-ID')
        ->setApplicationToken('APPLICATION-TOKEN')
        ->folders();
} catch (ApiException $e) {
    /** @var Ibp\Resources\Error */
    var_dump($e->error);
}
```

### Authentication

#### Utiliser un application id

```
$ibp->setApplicationId('APPLICATION-ID-HERE');
```

#### Utiliser un application token

```
$ibp->setApplicationToken('APPLICATION-TOKEN-HERE');
```

#### Utiliser un upload token

```
$ibp->setUploadToken('UPLOAD-TOKEN-HERE');
```

### Générer un upload token

```
$token = $ibp
    ->setApplicationId('app_id')
    ->setApplicationSecret('app_secret')
    ->uploadToken('john.doe@example.com');
```

Il est possible de passer un paramètre pour configurer la durée de vie du token (en seconde)

```
// Le token sera utilisable pendant 2 minutes (120 secondes)
$token = $ibp
    ->setApplicationId('app_id')
    ->setApplicationSecret('app_secret')
    ->uploadToken('john.doe@example.com', 120);
```

### Générer un application token

```
$token = $ibp
    ->setApplicationId('app_id')
    ->setApplicationSecret('app_secret')
    ->applicationToken();
```

Il est possible de passer un paramètre pour configurer la durée de vie du token (en seconde)

```
// Le token sera utilisable pendant 2 minutes (120 secondes)
$token = $ibp
    ->setApplicationId('app_id')
    ->setApplicationSecret('app_secret')
    ->applicationToken(120);
```

### Folders

#### Récupérer la liste des folders.

```
$folders = $ibp->folders();
```

#### Récupérer un folder.

```
$folder = $ibp->folder('591c57736afd7d0106486d02');
```

#### Créer un folder.

```
$folder = $ibp->createFolder('Mes documents');
```

#### Mettre à jour un folder.

```
$folder = $ibp->updateFolder('591d4dff22b60a00af674c52', 'Images');
```

#### Ajouter un file dans un folder.

```
$folder = $ibp->addFileInFolder('591d4dff22b60a00af674c52', '59142cd4a64da6014c769813');
```

#### Enlever un file d'un folder.

```
$deleted = $ibp->removeFileFromFolder('591d4dff22b60a00af674c52', '59142cd4a64da6014c769813');
```

### Files

#### Récupérer la liste des files.

```
$files = $ibp->files();
```

#### Récupérer un file.

```
$file = $ibp->file('59142cd4a64da6014c769813');
```

#### Tagger un file

```
$file = $ibp->TagFile('59142cd4a64da6014c769813', 'manual', ['tag 1', 'tag 2']);
```

#### Uploader un file

```
$fileContent = fopen(__DIR__. '/README.md', 'r');
$file = $ibp->uploadFile($fileContent);
```

#### Supprimer un fichier

```
$ibp->deleteFile('59142cd4a64da6014c769813');
```

### Application

#### Récupérer la liste des applications.

```
$apps = $ibp->applications();
```

#### Récupérer une application.

```
$app = $ibp->application('5911924f302f600102779d23');
```

#### Créer une application.

```
$app = $ibp->createApplication('Application iPhone v2', 'La nouvelle application iPhone ...');
```

#### Mettre à jour les infos d'une application.

```
$app = $ibp->updateApplication('591d57fe22b60a00e2075f12', 'Application Android v2', 'New Desc');
```

#### Supprimer une application

```
$isDeleted = $ibp->deleteApplication('591d57fe22b60a00e2075f12');
```

### Methodes

#### Récupérer la liste des methodes.

```
$methodes = $ibp->methodes();
```

#### Récupérer une methode.

```
$methode = $ibp->methode('5911924f302f600102779d23');
```

#### Créer une methode.

```
$methode = $ibp->createMethode([
    'context' => 'square',
    'generator' => 'Thumbor',
    'param' => [
        'force_ration' => '1:1',
        'crop_width' => 206,
        'crop_width' => 206,
        'crop_x' => 931,
        'crop_y' => 274
    ],
    'description' => 'Image carré'
]);
```

#### Mettre à jour les infos d'une application.

```
$methode = $ibp->updateMethode('591d57fe22b60a00e2075f12', [
    'context' => 'square',
    'generator' => 'Thumbor',
    'param' => [
        'force_ration' => '1:1',
        'crop_width' => 206,
        'crop_width' => 206,
        'crop_x' => 931,
        'crop_y' => 274,
    ],
]);
```

#### Supprimer une methode

```
$isDeleted = $ibp->deleteMethode('591d57fe22b60a00e2075f12');
```

### Pipelines

#### Récupérer la liste des pipelines.

```
$pipelines = $ibp->pipelines();
```

## Credits

Inspired by The [Forge SDK](https://github.com/themsaid/forge-sdk)
