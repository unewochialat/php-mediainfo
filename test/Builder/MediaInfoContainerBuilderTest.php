<?php

namespace Mhor\MediaInfo\Test\Builder;

use Mhor\MediaInfo\Builder\MediaInfoContainerBuilder;
use Mhor\MediaInfo\Factory\TypeFactory;
use Mhor\MediaInfo\Test\Stub\TrackTestType;

class MediaInfoContainerBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testSetVersion()
    {
        $mediaInfoContainerBuilder = new MediaInfoContainerBuilder();

        $mediaContainer = $mediaInfoContainerBuilder->build();
        $this->assertEquals(null, $mediaContainer->getVersion());

        $mediaInfoContainerBuilder->setVersion('2.0');
        $mediaContainer = $mediaInfoContainerBuilder->build();

        $this->assertEquals('2.0', $mediaContainer->getVersion());
    }

    public function testAddTrackType()
    {
        $mediaInfoContainerBuilder = new MediaInfoContainerBuilder();

        $mediaInfoContainerBuilder->addTrackType(TypeFactory::AUDIO, array());
        $mediaContainer = $mediaInfoContainerBuilder->build();
        $audios = $mediaContainer->getAudios();
        $this->assertEquals(0, count($audios[0]->get()));

        $mediaInfoContainerBuilder->addTrackType(TypeFactory::VIDEO, array());
        $mediaContainer = $mediaInfoContainerBuilder->build();
        $videos = $mediaContainer->getVideos();
        $this->assertEquals(0, count($videos[0]->get()));

        $mediaInfoContainerBuilder->addTrackType(TypeFactory::GENERAL, array());
        $mediaContainer = $mediaInfoContainerBuilder->build();
        $this->assertEquals(0, count($mediaContainer->getGeneral()->get()));

        $mediaInfoContainerBuilder->addTrackType(TypeFactory::IMAGE, array());
        $mediaContainer = $mediaInfoContainerBuilder->build();
        $images = $mediaContainer->getImages();
        $this->assertEquals(0, count($images[0]->get()));

        $mediaInfoContainerBuilder->addTrackType(TypeFactory::SUBTITLE, array());
        $mediaContainer = $mediaInfoContainerBuilder->build();
        $subtitles = $mediaContainer->getSubtitles();
        $this->assertEquals(0, count($subtitles[0]->get()));

        $mediaInfoContainerBuilder->addTrackType(TypeFactory::OTHER, array());
        $mediaContainer = $mediaInfoContainerBuilder->build();
        $others = $mediaContainer->getOthers();
        $this->assertEquals(0, count($others[0]->get()));
    }

    /**
     * @expectedException \Mhor\MediaInfo\Exception\UnknownTrackTypeException
     */
    public function testAddInvalidType()
    {
        $mediaInfoContainerBuilder = new MediaInfoContainerBuilder();
        $mediaInfoContainerBuilder->addTrackType('InvalidType', array());
    }

    /**
     * @expectedException \Exception
     */
    public function testAddInvalidTypeOnMediaInfoContainer()
    {
        $mediaInfoContainerBuilder = new MediaInfoContainerBuilder();
        $mediaInfoContainer = $mediaInfoContainerBuilder->build();
        $mediaInfoContainer->add(new TrackTestType());
    }
}
