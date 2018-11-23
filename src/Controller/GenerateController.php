<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\TileBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Endroid\Tile\Tile;
use Symfony\Component\Routing\RouterInterface;

final class GenerateController
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/{text}.{extension}", name="tile", requirements={"extension"="jpg|png|gif"})
     */
    public function generateAction(string $text, string $extension): Response
    {
        if (false !== strpos($text, ' ')) {
            return new RedirectResponse($this->router->generate('tile', [
                'text' => str_replace(' ', '_', $text),
                'extension' => $extension,
            ]));
        }

        $tile = new Tile();
        $tile->setText($text);
        $tile = $tile->get($extension);

        $mime_type = 'image/'.$extension;
        if ('jpg' == $extension) {
            $mime_type = 'image/jpeg';
        }

        return new Response($tile, 200, ['Content-Type' => $mime_type]);
    }
}
