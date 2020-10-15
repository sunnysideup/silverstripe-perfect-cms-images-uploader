# Install and ...

set perfect-cms-images-uploader.yml:

```yml

# see: https://github.com/sunnysideup/silverstripe-perfect_cms_images/blob/master/_config/perfect_cms_images.yml.example 
# for an example of a PerfectCmsImagesDefinition

Sunnysideup\PerfectCMSImagesUploader\Admin\UploadManyImages:
    class_fields_matchers:
        Page:
            MatchingCodeFields:
                - URLSegment
                - SomeOtherID
            ImageRelationShips:
                - MyImageField: PerfectCmsImagesDefinition1
                - MyManyManyRelationField: PerfectCmsImagesDefinition2
                - MyHasOneRelation: PerfectCmsImagesDefinition2
        MyDataObject: 
            AnotherImageField:
                - MyImageField: PerfectCmsImagesDefinition3
                - MyManyManyRelationField: PerfectCmsImagesDefinition3
                - MyHasOneRelation: PerfectCmsImagesDefinition1       
```
