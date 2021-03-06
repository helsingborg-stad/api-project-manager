<?php

namespace ApiProjectManager\Helper;

class CacheBust
{
    /**
     * Returns the revved/cache-busted file name of an asset.
     * @param string $name Asset name (array key) from rev-mainfest.json
     * @param boolean $returnName Returns $name if set to true while in dev mode
     * @return string filename of the asset (including directory above)
     */
    public static function name($name, $returnName = true)
    {
        $revManifest = self::getRevManifest();

        if (!isset($revManifest[$name])) {
            return;
        }

        return $revManifest[$name];
    }

    /**
     * Decode assets json to array
     * @return array containg assets filenames
     */
    public static function getRevManifest()
    {
        $jsonPath = APIPROJECTMANAGER_PATH . apply_filters('ApiProjectManager/Helper/CacheBust/RevManifestPath', 'assets/dist/manifest.json');

        if (file_exists($jsonPath)) {
            return json_decode(file_get_contents($jsonPath), true);
        } elseif (WP_DEBUG) {
            echo '<div style="color:red">Error: Assets not built. Go to ' . APIPROJECTMANAGER_PATH . ' and run gulp. See '. APIPROJECTMANAGER_PATH . 'README.md for more info.</div>';
        }
    }
}
