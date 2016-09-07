<?php

namespace Elseym\MirrorHandler;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class MirrorHandler
 */
class Mirror implements EventHandlerInterface
{
    const CONFIG_KEY = "mirror";

    /**
     * @param Event $event
     */
    public static function handle(Event $event)
    {
        $composer = $event->getComposer();
        $packageExtras = $composer->getPackage()->getExtra();

        if (!array_key_exists(self::CONFIG_KEY, $packageExtras)) {
            return;
        }

        $mirrorSpecs = (array)$packageExtras[self::CONFIG_KEY];

        $localRepo = $composer->getRepositoryManager()->getLocalRepository();
        $installationManager = $composer->getInstallationManager();

        $fs = new Filesystem();

        $io = $event->getIO();

        foreach ($mirrorSpecs as $packageSpec => $destinationPath) {
            if (strpos($packageSpec, "#") > -1) {
                list ($packageName, $packageConstraint) = explode("#", $packageSpec);
            } else {
                $packageName = $packageSpec;
                $packageConstraint = "*";
            }

            $package = $localRepo->findPackage($packageName, $packageConstraint);
            if (null === $package) {
                continue;
            }

            $packagePath = $installationManager->getInstallPath($package);

            $io->write("mirror <info>$packageName</info> to <info>$destinationPath</info>");
            $fs->mirror($packagePath, $destinationPath, null, ["override" => true, "delete" => true]);
        }
    }
}
