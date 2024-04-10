<?php

namespace App\Services;

use Bunny\Storage\Client;
use Bunny\Storage\Region;

class BunnyCDNService
{
    protected $client;

    public function __construct()
    {
        $apiKey = env('BUNNYCDN_API_KEY');
        $zoneName = env('BUNNYCDN_ZONE_NAME');
        $zoneRegion = env('BUNNYCDN_ZONE_REGION');

        // Obteniendo la URL base para la región especificada.
        $baseUrl = Region::getBaseUrl($zoneRegion);
        
        // Inicializa el cliente de BunnyCDN con la URL base correcta.
        $this->client = new Client($apiKey, $zoneName, $baseUrl);
    }

    public function upload($localFilePath, $remoteFilePath, $withChecksum = true)
    {
        return $this->client->upload($localFilePath, $remoteFilePath, $withChecksum);
    }

    public function delete($filePath)
    {
        return $this->client->delete($filePath);
    }

    public function listFiles($path = '')
    {
        return $this->client->listFiles($path);
    }

    public function info($filePath)
    {
        return $this->client->info($filePath);
    }

    public function deleteMultiple(array $files)
    {
        return $this->client->deleteMultiple($files);
    }

    public function putContents($filePath, $content, $withChecksum = true)
    {
        return $this->client->putContents($filePath, $content, $withChecksum);
    }

    public function getContents($filePath)
    {
        return $this->client->getContents($filePath);
    }
}
