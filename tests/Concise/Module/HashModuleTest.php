<?php

namespace Concise\Module;

/**
 * Testing hashes is quite easy. We want to select values that when hashed will
 * result in all the possible characters (16 for hexadecimal) in the one hash.
 *
 * The test _testGenerateValues is disable as its only need to be run once to
 * generate the base data provider to be used for the rest of the tests.
 *
 * @group matcher
 * @group #269
 */
class HashModuleTest extends AbstractModuleTestCase
{
    /**
     * These are not random, they have been generated by _testGenerateValues()
     * so that they all contain all 16 possible hexadecimal characters.
     *
     * @var array
     */
    protected static $data = array(
        'md2' => '644737658',
        'md4' => '76041011',
        'md5' => '765747394',
        'sha1' => '2121945217',
        'sha224' => '1992137930',
        'sha256' => '1409763972',
        'sha384' => '923831157',
        'sha512' => '2009834756',
        'ripemd128' => '1700793405',
        'ripemd160' => '115914122',
        'ripemd256' => '2043415493',
        'ripemd320' => '192604904',
        'whirlpool' => '27326413',
        'tiger128,3' => '2090191574',
        'tiger160,3' => '1473588334',
        'tiger192,3' => '1052121460',
        'tiger128,4' => '1325565485',
        'tiger160,4' => '195633033',
        'tiger192,4' => '1129380416',
        'haval128,3' => '1874865090',
        'haval160,3' => '665890248',
        'haval192,3' => '1290127780',
        'haval224,3' => '1967643772',
        'haval256,3' => '1567640248',
        'haval128,4' => '88762273',
        'haval160,4' => '1044306765',
        'haval192,4' => '1987085131',
        'haval224,4' => '1474207093',
        'haval256,4' => '453892265',
        'haval128,5' => '1129800014',
        'haval160,5' => '1562869785',
        'haval192,5' => '1209126060',
        'haval224,5' => '1910603999',
        'haval256,5' => '827858962',
        'snefru' => '2053211574',
        'snefru256' => '2050122072',
        'gost' => '791752798',
        // The following are shorter than 16 characters and so it is
        // impossible for them to contain all characters. In this case we
        // just use random values.
        'crc32' => '2070072372',
        'crc32b' => '1157365562',
        'adler32' => '289014769',
        'fnv132' => '1312987169',
        'fnv164' => '1920646076',
        'joaat' => '1388690451',
    );

    public function setUp()
    {
        parent::setUp();
        $this->module = new HashModule();
    }

    /**
     * The underscore prefix is becuase we don't want to actually run this every
     * time.
     */
    public function _testGenerateValues()
    {
        foreach (hash_algos() as $algorithm) {
            $found = false;

            // Limit it so we know to give up at an acceptable point.
            for ($i = 0; $i < 1000; ++$i) {
                $v = rand();
                $hash = hash($algorithm, $v);
                $cs = array();
                foreach (str_split($hash) as $c) {
                    $cs[$c] = true;
                }
                if (count($cs) == 16) {
                    echo "$algorithm('$v') = $hash\n";
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                /** @noinspection PhpUndefinedVariableInspection */
                echo "$algorithm ws not found, lets use $algorithm('$v') = $hash\n";
            }
        }
        exit;
    }

    /**
     * This is for futuring proofing that new alogoriths introduced in later
     * versions of PHP will have tests created for them.
     */
    public function testAllAlgorithmsHaveBeenCovered()
    {
        $this->assertArray(self::$data)->hasKeys(hash_algos());
    }

    public function data()
    {
        $tests = array();
        $knownAlgorithms = hash_algos();

        foreach (self::$data as $algorithm => $value) {
            // Some algorithms are not available in earlier versions of PHP so
            // theres no need to have tests for them.
            if (!in_array($algorithm, $knownAlgorithms)) {
                continue;
            }

            $raw = explode(',', $algorithm);
            $a = ucfirst($raw[0]);

            // passes
            $v = hash($algorithm, $value);
            $tests["$algorithm lower"] = array("isAValid$a", $v);
            $tests["$algorithm upper"] = array("isAValid$a", strtoupper($v));

            $tests["not $algorithm lower"] = array(
                "isNotAValid$a",
                $v,
                "hash \"$v\" is not a valid $raw[0]"
            );
            $tests["not $algorithm upper"] = array(
                "isNotAValid$a",
                strtoupper($v),
                "hash \"" . strtoupper($v) . "\" is not a valid $raw[0]"
            );

            // failures
            $tests["$algorithm too short"] = array(
                "isAValid$a",
                '0',
                "hash \"0\" is a valid $raw[0]"
            );
            $tests["$algorithm too long"] = array(
                "isAValid$a",
                "0$v",
                "hash \"0$v\" is a valid $raw[0]"
            );
            $tests["$algorithm bad character"] = array(
                "isAValid$a",
                "z" . substr($v, 1),
                "hash \"z" . substr($v, 1) . "\" is a valid $raw[0]"
            );
            $tests["not $algorithm too short"] = array(
                "isNotAValid$a",
                '0'
            );
            $tests["not $algorithm too long"] = array(
                "isNotAValid$a",
                "0$v"
            );
            $tests["not $algorithm bad character"] = array(
                "isNotAValid$a",
                "z" . substr($v, 1)
            );
        }

        return $tests;
    }

    /**
     * @dataProvider data
     */
    public function testHash($hash, $value, $error = null)
    {
        if ($error) {
            $this->expectFailure($error);
        }
        $this->assertHash($value)->$hash;
    }
}
