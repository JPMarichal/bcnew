<?php
namespace App\Contracts;

interface NewsContentScraperInterface
{
    /**
     * Prepara el scraper con una URL específica.
     *
     * @param string $url La URL de la página a escrapear.
     */
    public function prepare(string $url): void;

    /**
     * Extrae el contenido principal del artículo.
     *
     * @return string|null El contenido extraído o null si no se encuentra.
     */
    public function extractContent(): ?string;

    /**
     * Extrae la imagen destacada del artículo.
     *
     * @return string|null La URL de la imagen destacada o null si no se encuentra.
     */
    public function extractFeaturedImage(): ?string;

    /**
     * Extrae la descripción del artículo.
     *
     * @return string|null La descripción extraída o null si no se encuentra.
     */
    public function extractDescription(): ?string;

    /**
     * Extrae el autor del artículo.
     *
     * @return string|null El autor extraído o null si no se encuentra.
     */
    public function extractAuthor(): ?string;
}

