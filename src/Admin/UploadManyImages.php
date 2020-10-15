<?php

namespace Sunnysideup\PerfectCMSImagesUploader\Admin;


use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\Form;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Image;
use Sunnysideup\PerfectCmsImages\Forms\PerfectCmsImagesUploadField;

class ProductImageUpload extends LeftAndMain
{
    private static $menu_priority = 3.3;
    private static $url_segment = 'upload-images';

    private static $allowed_actions = [
        'StepOneSelect',
        'StepTwoAttach',
    ];

    /**
     * example values:
     *         SiteTree::class => [
     *             'ImageField' => [
     *                 'URLSegment',
     *                 'SomeOtherID'
     *             ],
     *         ]

     *
     * @var array
     */
    private static $class_fields_matchers = [];


    /**
     * set the class and relationship name
     * @return Form
     */
    public function StepOneSelect()
    {
        $listOfOptions = $this->Config()->get('class_fields_matchers');
        $options = [];
        foreach($listOfOptions as $className => $classNameDetails) {
            foreach($classNameDetails as $relationship => $matchingFields) {
                $options[$className.'_'.$relationship.'_'] = Injector::inst()->get($className)->singularName().'RelationShipNameHere';
            }
        }
        return Form::create(
            $this,
            "EditForm",
            FieldList::create([
                DropdownField::create(
                    'ClassName',
                    'ObjectType',
                    $options
                ),
            ])
        );

    }

    protected $className = '';

    protected $relationshipName= '';

    /**
     * @return Form
     */
    public function StepTwoAttach()
    {
        return Form::create(
            $this,
            "EditForm",
            FieldList::create([
                PerfectCmsImagesUploadField::create(
                    'AttachedFile',
                    DBHTMLText::create_field(
                        'HTMLFragment',
                        "<h2>Rapid image uploader</h2>" .
                        "<p>
                            Either select files or drag/drop files on to the box below.
                            The filename should start with the Code for the Items then follwed by '_' then anything else. For example;
                        </p>" .
                        "<blockquote>14184_test.jpg<br>14184_test2.jpg</blockquote>"
                    )
                )
                    ->setIsMultiUpload(true)
                    ->setAfterUpload(function (HTTPResponse $response) {
                        // Read data from the original response
                        $data = json_decode($response->getBody())[0];

                        // preg the id from the title of the file
                        $id = preg_split('[/._]', $data->title, PREG_SPLIT_OFFSET_CAPTURE);

                        $object = $this->className::filter([$field => $id]);
                        // Find product from id
                        if ($object->count() === 1) {

                            // Attach image to found prodcut
                            $matchingProduct->{$this->relationshipName}()->add(
                                Image::get_by_id($data->id)
                            );
                        }
                        // Return the original response (untouched)
                        return $response;
                    })
                    ->addExtraClass('panel--padded')
            ])
        );
    }
}