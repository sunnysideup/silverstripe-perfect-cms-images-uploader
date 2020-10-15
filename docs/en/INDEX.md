# Install and ...

set perfect-cms-images-uploader.yml:

```yml

Sunnysideup\PerfectCMSImagesUploader\Admin\UploadManyImages:
    class_fields_matchers:
        Page:
            MatchingCodeFields:
                - URLSegment
                - SomeOtherID
            ImageRelationShips:
                - MyImageField: PerfectCmsImagesTemplate1
                - MyManyManyRelationField: PerfectCmsImagesTemplate1
                - MyHasOneRelation: PerfectCmsImagesTemplate2
```
