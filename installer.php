<?php
/**
 * Installer for Box3 (humbug/box).
 *
 * It downloads the latest "box.phar" (The PHP archiver) from the releases
 * page at https://github.com/humbug/box/releases .
 *
 * - Issues: https://github.com/KEINOS/Phar_Box3_installer/issues
 * - Latest download url: https://github.com/KEINOS/Phar_Box3_installer
 * - By: KEINOS @ https://github.com/KEINOS/
 *
 * ## About Box3
 * Box3 is a fork of Box2 ( https://github.com/box-project/box2 ) mantained by
 * https://github.com/humbug/box .
 *
 * ## About this script
 * This script is a fork of Box2's installer and customized for Box3.
 *
 * - Original installer (Box2)
 *     https://github.com/box-project/box2/blob/gh-pages/installer.php
 *
 */

namespace

{
    use Herrera\Version\Comparator;
    use Herrera\Version\Dumper;
    use Herrera\Version\Parser;

    /* Initialization ------------------------------------------------------- */

    const EXIT_ON_FAIL = true;
    const DO_NOT_EXIT  = false;

    defined('STDIN') or define('STDIN', fopen("php://stdin", "r"));

    $n        = PHP_EOL;
    $name_app = 'box.phar';
    $name_ua  = 'humbug/box.phar downloader'; //User-Agent
    $url_release_box  = 'https://api.github.com/repos/humbug/box/releases';
    $url_manifest     = 'https://keinos.github.io/Phar_Box3_installer/manifest.json';
    $url_manifest_sig = 'https://keinos.github.io/Phar_Box3_installer/manifest.json.sig';
    $hash_algo_base   = 'sha256';

    set_error_handler(
        function ($code, $message, $file, $line) use ($n) {
            if ($code & error_reporting()) {
                echo "$n{$n}Error: $message$n$n";
                echo "{$n}BackTrace:{$n}";
                echo 'Line:', debug_backtrace()[0]['line'], $n;
                exit(1);
            }
        }
    );

    /* Title ---------------------------------------------------------------- */

    echo $n;
    echo "=============$n";
    echo "Box Installer$n";
    echo "=============$n";
    echo $n;

    /* Environment check ---------------------------------------------------- */

    echo "Environment Check$n";
    echo "-----------------$n";
    echo $n;

    echo "\"-\" indicates success.$n";
    echo "\"*\" indicates error.  $n";
    echo $n;

    $hasNoErrors = true; //truns false on error

    // check version
    check(
        'You have a supported min version of PHP (>= 5.3.3).',
        'You need PHP 5.3.3 or greater.',
        function () {
            return version_compare(PHP_VERSION, '5.3.3', '>=');
        }
    );

    // ask whether use BOX2 or not if  =< 7.1.0

    // check phar extension
    check(
        'You have the "phar" extension installed.',
        'You need to have the "phar" extension installed.',
        function () {
            return extension_loaded('phar');
        }
    );

    // check phar extension version
    check(
        'You have a supported version of the "phar" extension.',
        'You need a newer version of the "phar" extension (>=2.0).',
        function () {
            if (! extension_loaded('phar')) {
                return false;
            }
            $phar = new ReflectionExtension('phar');
            return version_compare($phar->getVersion(), '2.0', '>=');
        }
    );

    // check openssl extension
    check(
        'You have the "openssl" extension installed.',
        'Notice: The "openssl" extension will be needed to sign with private keys.',
        function () {
            return extension_loaded('openssl');
        }
    );

    // check phar readonly setting
    check(
        'The "phar.readonly" setting is off.',
        'Notice: The "phar.readonly" setting needs to be off to create Phars.',
        function () {
            return (false == ini_get('phar.readonly'));
        }
    );

    // check detect unicode setting
    check(
        'The "detect_unicode" setting is off.',
        'The "detect_unicode" setting needs to be off.',
        function () {
            return (false == ini_get('detect_unicode'));
        }
    );

    // check suhosin setting
    if (extension_loaded('suhosin')) {
        check(
            'The "phar" stream wrapper is allowed by suhosin.',
            'The "phar" stream wrapper is blocked by suhosin.',
            function () {
                $white = ini_get('suhosin.executor.include.whitelist');
                $black = ini_get('suhosin.executor.include.blacklist');

                if ((false === stripos($white, 'phar'))
                    || (false !== stripos($black, 'phar'))) {
                    return false;
                }

                return true;
            }
        );
    }

    // check allow url open setting
    check(
        'The "allow_url_fopen" setting is on.',
        'The "allow_url_fopen" setting needs to be on.',
        function () {
            return (true == ini_get('allow_url_fopen'));
        }
    );

    // check ioncube loader version
    if (extension_loaded('ionCube_loader')) {
        check(
            'You have a supported version of ionCube Loader.',
            'Your version of the ionCube Loader is not compatible with Phars.',
            function () {
                return (40009 > ioncube_loader_version());
            }
        );
    }

    // check apc cli caching
    if (! defined('HHVM_VERSION') && ! extension_loaded('apcu') && extension_loaded('apc')) {
        check(
            'The "apc.enable_cli" setting is off.',
            'Notice: The "apc.enable_cli" is on and may cause problems with Phars.',
            function () {
                return (false == ini_get('apc.enable_cli'));
            }
        );
    }

    // ask to continue if check fail
    if ($hasNoErrors) {
        echo $n;
        echo 'Everything seems good!', $n;
        echo $n;
    } else {
        echo $n;
        echo 'You need to fix above error in order to use BOX3.', $n;
        echo ' - Path to your php.ini: ', php_ini_loaded_file(), $n;
        echo $n;

        if (! askToContinue('Continue download BOX3(box.phar) anyway? (y/n)', 'y')) {
            echo 'Installation aborted.', $n;
            echo $n;
            echo 'Exit BOX3 installer.', $n,$n;
            exit(1);
        }

        echo "Continuing ...$n$n";
    }

    /* Download ------------------------------------------------------------- */

    $hasNoErrors = true; //reset flag
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => 'User-Agent: ' . $name_ua,
        ],
    ];
    $context = stream_context_create($options);

    echo 'Download', $n;
    echo '--------', $n;
    echo $n;

    check(
        "Fetching releases \t... OK",
        'Notice: Couldn\'t fetch releases from: ' . $url_release_box,
        function () use (&$str_releases, $url_release_box, $context) {
            $str_releases = file_get_contents($url_release_box, false, $context);
            return ! empty(trim($str_releases));
        },
        EXIT_ON_FAIL
    );

    echo " - Reading releases:$n";

    $json_releases   = json_decode($str_releases);
    $latest          = $json_releases[0];
    $latest->version = Parser::toVersion($latest->tag_name);

    foreach ($json_releases as $item) {
        echo "\t", 'Release: ', $item->tag_name;
        if ($item->draft) {
            echo ' -> Skip (Draft)', $n;
            continue;
        }
        echo $n;
        $item->version = Parser::toVersion($item->tag_name);
        if (isset($latest->version)) {
            if (Comparator::isGreaterThan($item->version, $latest->version)) {
                $latest = $item;
            }
        }
    }

    $version_latest = Dumper::toString($latest->version);

    echo $n, "\t", 'Latest release -> ', $version_latest;
    echo $n, $n;

    check(
        "Application to download \t... Found.(v{$version_latest})",
        "Application to download \t... NOT found",
        function () use ($latest, $name_app) {
            $asset            = $latest->assets[0];
            $has_name_app     = ($asset->name === $name_app);
            $has_url_download = isset($asset->browser_download_url);

            return $latest && $has_name_app && $has_url_download ;
        }
    );

    echo " - Fetching manifest file to verify \t... ";

    if (! $string_manifest = file_get_contents($url_manifest)) {
        dieMsg('Can not fetch manifest.');
    }
    $json_manifest = json_decode($string_manifest);
    $hash_manifest = hash($hash_algo_base, $string_manifest);
    echo 'OK', $n;

    echo "\t - Fetching manifest signature \t... ";
    if (! $string_manifest_sig = file_get_contents($url_manifest_sig)) {
        dieMsg('Can NOT fetch manifest\s signature.');
    }
    echo 'OK', $n;

    echo "\t - Validating manifest \t... ";
    if ($hash_manifest !== $string_manifest_sig) {
        dieMsg('Invalid manifest file. Signature does not match');
    }
    echo 'OK.(Valid manifest)', $n;


    echo " - Downloading latest Box\t... ";

    $browser_download_url = $latest->assets[0]->browser_download_url;

    echo ( file_put_contents(
        $name_app,
        file_get_contents($browser_download_url, false, $context)
    )) ? 'OK -> ' . $name_app : 'FAIL! Can not put file. Check dir permission.', $n;

    check(
        "Box successfuly downloaded! \t${version_latest} -> {$name_app}",
        "The downloaded file was corrupted.(Deleted)",
        function () use ($name_app, $json_manifest, $version_latest) {
            echo " - Checking file signature \t... ";

            $n              = PHP_EOL;
            $algos_to_check = ['md5','sha256'];
            $result         = true; // Flag of verification

            foreach ($algos_to_check as $algo) {
                $hash_manifest = fetchHashFromManifest(
                    $json_manifest,
                    $version_latest,
                    $algo
                );
                $hash_download = hash_file($algo, $name_app);
                /*
                echo $hash_manifest, $n;
                echo $hash_download, $n;
                */
                $result = ($hash_manifest === $hash_download) && $result;
            }

            if (! $result) {
                echo 'NG', $n;
                echo ' - Deleting downloaded file ... ';
                echo (unlink($name_app)) ? 'OK (Unlinked)' : 'NG (Can not unlink)', $n;
            }

            echo 'OK', $n;

            return $result;
        },
        EXIT_ON_FAIL
    );

    echo " - Instance creation test \t... ";
    try {
        new Phar($name_app);
        echo 'OK', $n;
    } catch (Exception $e) {
        echo 'FAIL! Can\'t create Phar instance.', $n;

        throw $e;
    }

    // `chmod` installer
    check(
        "Making Box executable \t... OK",
        "Making Box executable \t... FAIL! Check dir/file permission.",
        function () use ($name_app) {
            return chmod($name_app, 0755);
        }
    );


    echo $n, 'Box installed!', $n, $n;

    /* Function ------------------------------------------------------------- */

    /**
     * Ask user to continue via standard input.
     * 
     * @param  string $question         The message to display.
     * @param  string $stringToContinue The expected string to continue.
     * @return boolean                  True if input equal to $stringToContinue             
     */
    function askToContinue($question, $stringToContinue)
    {
        echo $question . ':';
        $stdin = trim(fgets(STDIN)) ?: $stringToContinue;
        return $stringToContinue === $stdin;
    }

    /**
     * Checks a condition, outputs a message, and exits if failed.
     *
     * @param string   $success   The success message.
     * @param string   $failure   The failure message.
     * @param callable $condition The condition to check.
     * @param boolean  $exit      Exit on failure? EXIT_ON_FAIL or DO_NOT_EXIT
     */
    function check($success, $failure, $condition, $exit = DO_NOT_EXIT)
    {
        global $n, $hasNoErrors;

        $result = $condition();

        if ($result) {
            echo ' - ', $success, $n;
        } else {
            echo ' * ', $failure, $n;

            if (EXIT_ON_FAIL === $exit) {
                exit(1);
            }
        }

        $hasNoErrors = $hasNoErrors && $result;

        return ($result);
    }

    function fetchHashFromManifest($json_manifest, $version, $hash_algo)
    {
        $release = $json_manifest->box_release->$version;
        return  $release->hashes->$hash_algo;
    }

}

namespace Herrera\Version\Exception

{
    use Exception;

    /**
     * Throw if an invalid version string representation is used.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     */
    class InvalidStringRepresentationException extends VersionException
    {
        /**
         * The invalid string representation.
         *
         * @var string
         */
        private $version;

        /**
         * Sets the invalid string representation.
         *
         * @param string $version The string representation.
         */
        public function __construct($version)
        {
            parent::__construct(
                sprintf(
                    'The version string representation "%s" is invalid.',
                    $version
                )
            );

            $this->version = $version;
        }

        /**
         * Returns the invalid string representation.
         *
         * @return string The invalid string representation.
         */
        public function getVersion()
        {
            return $this->version;
        }
    }

    /**
     * The base library exception class.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     */
    class VersionException extends Exception
    {
    }
}

namespace Herrera\Version

{
    use Herrera\Version\Exception\InvalidStringRepresentationException;

    /**
     * Compares two Version instances.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     */
    class Comparator
    {
        /**
         * The version is equal to another.
         */
        const EQUAL_TO = 0;

        /**
         * The version is greater than another.
         */
        const GREATER_THAN = 1;

        /**
         * The version is less than another.
         */
        const LESS_THAN = -1;

        /**
         * Compares one version with another.
         *
         * @param Version $left The left version to compare.
         * @param Version $right The right version to compare.
         *
         * @return integer Returns Comparator::EQUAL_TO if the two versions are
         * equal. If the left version is less than the right
         * version, Comparator::LESS_THAN is returned. If the left
         * version is greater than the right version,
         * Comparator::GREATER_THAN is returned.
         */
        public static function compareTo(Version $left, Version $right)
        {
            switch (true) {
                case ($left->getMajor() < $right->getMajor()):
                    return self::LESS_THAN;
                case ($left->getMajor() > $right->getMajor()):
                    return self::GREATER_THAN;
                case ($left->getMinor() > $right->getMinor()):
                    return self::GREATER_THAN;
                case ($left->getMinor() < $right->getMinor()):
                    return self::LESS_THAN;
                case ($left->getPatch() > $right->getPatch()):
                    return self::GREATER_THAN;
                case ($left->getPatch() < $right->getPatch()):
                    return self::LESS_THAN;
                // @codeCoverageIgnoreStart
            }
            // @codeCoverageIgnoreEnd

            return self::compareIdentifiers(
                $left->getPreRelease(),
                $right->getPreRelease()
            );
        }

        /**
         * Checks if the left version is equal to the right.
         *
         * @param Version $left The left version to compare.
         * @param Version $right The right version to compare.
         *
         * @return boolean TRUE if the left version is equal to the right, FALSE
         * if not.
         */
        public static function isEqualTo(Version $left, Version $right)
        {
            return (self::EQUAL_TO === self::compareTo($left, $right));
        }

        /**
         * Checks if the left version is greater than the right.
         *
         * @param Version $left The left version to compare.
         * @param Version $right The right version to compare.
         *
         * @return boolean TRUE if the left version is greater than the right,
         * FALSE if not.
         */
        public static function isGreaterThan(Version $left, Version $right)
        {
            return (self::GREATER_THAN === self::compareTo($left, $right));
        }

        /**
         * Checks if the left version is less than the right.
         *
         * @param Version $left The left version to compare.
         * @param Version $right The right version to compare.
         *
         * @return boolean TRUE if the left version is less than the right,
         * FALSE if not.
         */
        public static function isLessThan(Version $left, Version $right)
        {
            return (self::LESS_THAN === self::compareTo($left, $right));
        }

        /**
         * Compares the identifier components of the left and right versions.
         *
         * @param array $left The left identifiers.
         * @param array $right The right identifiers.
         *
         * @return integer Returns Comparator::EQUAL_TO if the two identifiers are
         * equal. If the left identifiers is less than the right
         * identifiers, Comparator::LESS_THAN is returned. If the
         * left identifiers is greater than the right identifiers,
         * Comparator::GREATER_THAN is returned.
         */
        public static function compareIdentifiers(array $left, array $right)
        {
            if ($left && empty($right)) {
                return self::LESS_THAN;
            } elseif (empty($left) && $right) {
                return self::GREATER_THAN;
            }

            $l = $left;
            $r = $right;
            $x = self::GREATER_THAN;
            $y = self::LESS_THAN;

            if (count($l) < count($r)) {
                $l = $right;
                $r = $left;
                $x = self::LESS_THAN;
                $y = self::GREATER_THAN;
            }

            foreach (array_keys($l) as $i) {
                if (!isset($r[$i])) {
                    return $x;
                }

                if ($l[$i] === $r[$i]) {
                    continue;
                }

                if (true === ($li = (false != preg_match('/^\d+$/', $l[$i])))) {
                    $l[$i] = intval($l[$i]);
                }

                if (true === ($ri = (false != preg_match('/^\d+$/', $r[$i])))) {
                    $r[$i] = intval($r[$i]);
                }

                if ($li && $ri) {
                    return ($l[$i] > $r[$i]) ? $x : $y;
                } elseif (!$li && $ri) {
                    return $x;
                } elseif ($li && !$ri) {
                    return $y;
                }

                return strcmp($l[$i], $r[$i]);
            }

            return self::EQUAL_TO;
        }
    }

    /**
     * Dumps the Version instance to a variety of formats.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     */
    class Dumper
    {
        /**
         * Returns the components of a Version instance.
         *
         * @param Version $version A version.
         *
         * @return array The components.
         */
        public static function toComponents(Version $version)
        {
            return array(
                Parser::MAJOR => $version->getMajor(),
                Parser::MINOR => $version->getMinor(),
                Parser::PATCH => $version->getPatch(),
                Parser::PRE_RELEASE => $version->getPreRelease(),
                Parser::BUILD => $version->getBuild()
            );
        }

        /**
         * Returns the string representation of a Version instance.
         *
         * @param Version $version A version.
         *
         * @return string The string representation.
         */
        public static function toString(Version $version)
        {
            return sprintf(
                '%d.%d.%d%s%s',
                $version->getMajor(),
                $version->getMinor(),
                $version->getPatch(),
                $version->getPreRelease()
                    ? '-' . join('.', $version->getPreRelease())
                    : '',
                $version->getBuild()
                    ? '+' . join('.', $version->getBuild())
                    : ''
            );
        }
    }

    /**
     * Parses the string representation of a version number.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     */
    class Parser
    {
        /**
         * The build metadata component.
         */
        const BUILD = 'build';

        /**
         * The major version number component.
         */
        const MAJOR = 'major';

        /**
         * The minor version number component.
         */
        const MINOR = 'minor';

        /**
         * The patch version number component.
         */
        const PATCH = 'patch';

        /**
         * The pre-release version number component.
         */
        const PRE_RELEASE = 'pre';

        /**
         * Returns a Version builder for the string representation.
         *
         * @param string $version The string representation.
         *
         * @return Builder A Version builder.
         */
        public static function toBuilder($version)
        {
            return Builder::create()->importComponents(
                self::toComponents($version)
            );
        }

        /**
         * Returns the components of the string representation.
         *
         * @param string $version The string representation.
         *
         * @return array The components of the version.
         *
         * @throws InvalidStringRepresentationException If the string representation
         * is invalid.
         */
        public static function toComponents($version)
        {
            if (!Validator::isVersion($version)) {
                throw new InvalidStringRepresentationException($version);
            }

            if (false !== strpos($version, '+')) {
                list($version, $build) = explode('+', $version);

                $build = explode('.', $build);
            }

            if (false !== strpos($version, '-')) {
                list($version, $pre) = explode('-', $version);

                $pre = explode('.', $pre);
            }

            list(
                $major,
                $minor,
                $patch
                ) = explode('.', $version);

            return array(
                self::MAJOR => intval($major),
                self::MINOR => intval($minor),
                self::PATCH => intval($patch),
                self::PRE_RELEASE => isset($pre) ? $pre : array(),
                self::BUILD => isset($build) ? $build : array(),
            );
        }

        /**
         * Returns a Version instance for the string representation.
         *
         * @param string $version The string representation.
         *
         * @return Version A Version instance.
         */
        public static function toVersion($version)
        {
            $components = self::toComponents($version);

            return new Version(
                $components['major'],
                $components['minor'],
                $components['patch'],
                $components['pre'],
                $components['build']
            );
        }
    }

    /**
     * Validates version information.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     */
    class Validator
    {
        /**
         * The regular expression for a valid identifier.
         */
        const IDENTIFIER_REGEX = '/^[0-9A-Za-z\-]+$/';

        /**
         * The regular expression for a valid semantic version number.
         */
        const VERSION_REGEX = '/^\d+\.\d+\.\d+(?:-([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?(?:\+([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?$/';

        /**
         * Checks if a identifier is valid.
         *
         * @param string $identifier A identifier.
         *
         * @return boolean TRUE if the identifier is valid, FALSE If not.
         */
        public static function isIdentifier($identifier)
        {
            return (true == preg_match(self::IDENTIFIER_REGEX, $identifier));
        }

        /**
         * Checks if a number is a valid version number.
         *
         * @param integer $number A number.
         *
         * @return boolean TRUE if the number is valid, FALSE If not.
         */
        public static function isNumber($number)
        {
            return (true == preg_match('/^\d+$/', $number));
        }

        /**
         * Checks if the string representation of a version number is valid.
         *
         * @param string $version The string representation.
         *
         * @return boolean TRUE if the string representation is valid, FALSE if not.
         */
        public static function isVersion($version)
        {
            return (true == preg_match(self::VERSION_REGEX, $version));
        }
    }

    /**
     * Stores and returns the version information.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     */
    class Version
    {
        /**
         * The build metadata identifiers.
         *
         * @var array
         */
        protected $build;

        /**
         * The major version number.
         *
         * @var integer
         */
        protected $major;

        /**
         * The minor version number.
         *
         * @var integer
         */
        protected $minor;

        /**
         * The patch version number.
         *
         * @var integer
         */
        protected $patch;

        /**
         * The pre-release version identifiers.
         *
         * @var array
         */
        protected $preRelease;

        /**
         * Sets the version information.
         *
         * @param integer $major The major version number.
         * @param integer $minor The minor version number.
         * @param integer $patch The patch version number.
         * @param array $pre The pre-release version identifiers.
         * @param array $build The build metadata identifiers.
         */
        public function __construct(
            $major = 0,
            $minor = 0,
            $patch = 0,
            array $pre = array(),
            array $build = array()
        ) {
            $this->build = $build;
            $this->major = $major;
            $this->minor = $minor;
            $this->patch = $patch;
            $this->preRelease = $pre;
        }

        /**
         * Returns the build metadata identifiers.
         *
         * @return array The build metadata identifiers.
         */
        public function getBuild()
        {
            return $this->build;
        }

        /**
         * Returns the major version number.
         *
         * @return integer The major version number.
         */
        public function getMajor()
        {
            return $this->major;
        }

        /**
         * Returns the minor version number.
         *
         * @return integer The minor version number.
         */
        public function getMinor()
        {
            return $this->minor;
        }

        /**
         * Returns the patch version number.
         *
         * @return integer The patch version number.
         */
        public function getPatch()
        {
            return $this->patch;
        }

        /**
         * Returns the pre-release version identifiers.
         *
         * @return array The pre-release version identifiers.
         */
        public function getPreRelease()
        {
            return $this->preRelease;
        }
    }
}
