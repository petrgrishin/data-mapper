<?php
use PetrGrishin\DataMapper\DataMapper;

/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

class DataMapperTest extends PHPUnit_Framework_TestCase {

    public function checkList() {
        return array(
            array(
                array(
                    'a' => 'aa',
                    'b' => 'bb',
                    'c' => array(
                        'd' => 'dd',
                        'e' => 'ee',
                        'x' => array(
                            'z' => 'zz',
                        ),
                        'u' => 'uu',
                    ),
                ),
                array(
                    'a' => 1,
                    'b' => 2,
                    'c' => array(
                        'd' => 3,
                        'e' => 4,
                        'f' => 5,
                        'x' => array(
                            'y' => 7,
                            'z' => 8,
                        ),
                        'u' => array(
                            'key' => 'value',
                        ),
                    ),
                    'g' => 6,
                ), array(
                'aa' => 1,
                'bb' => 2,
                'dd' => 3,
                'ee' => 4,
                'zz' => 8,
                'uu' => array(
                    'key' => 'value',
                ),
            )
            ),
            array(
                array(
                    'a' => 'aa',
                    'b' => 'bb',
                    'c' => array(
                        'd' => 'dd',
                        'e' => 'ee',
                        'x' => array(
                            'z' => 'zz',
                        ),
                        'u' => 'uu',
                    ),
                ),
                array(
                    'a' => 1,
                    'b' => 2,
                    'c' => array(
                        'd' => 3,
                        'e' => 4,
                        'f' => 5,
                        'x' => 1,
                        'u' => array(
                            'key' => 'value',
                        ),
                    ),
                    'g' => 6,
                ),
                array(
                    'aa' => 1,
                    'bb' => 2,
                    'dd' => 3,
                    'ee' => 4,
                    'uu' => array(
                        'key' => 'value',
                    ),
                )
            )
        );
    }

    /**
     * @dataProvider checkList
     * @param array $map
     * @param array $source
     * @param array $destination
     * @throws Exception
     */
    public function testGetDataDestination($map, $source, $destination) {
        $dataMapper = new DataMapper($map);
        $dataMapper->setData($source);
        $this->assertEquals($destination, $dataMapper->getData());
    }
}
