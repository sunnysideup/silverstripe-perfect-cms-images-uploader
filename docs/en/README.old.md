#Email Address Database Field

A database field specifically for email addresses.

## Usage in model

```php

    MyClass extends DataObject
    {
        private static $db = array("MyEmail" => "EmailAddress");
    }
```

## Usage in templates
 
```html
    $MyEmail.HiddenEmailAddress.RAW
```

The `RAW` part is important.

# Example

Adding a tab to the CMS page where emails can be added in a GridField.

## Definition of the classes

```php
    class Page extends SiteTree
    {

        private static $has_many = array(
            'Emails' => 'Page_Email'
        );

        /**
         * CMS Fields
         * @return FieldList
         */
        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            $fields->addFieldToTab(
                'Root.Emails',
                GridField::create(
                    'Emails',
                    'Emails',
                    Page_Email::get(),
                    GridFieldConfig_RecordEditor::create()
                )
            );
            return $fields;
        }

    }

    class Page_Controller extends ContentController 
    {
    }


    class Page_Email extends DataObject
    {

        private static $db = array(
            'Title' => 'EmailAddress'
        );

        private static $has_one = array(
            'Page' => 'Page'
        );


    }
```

## Template file

```html
    <% loop $Emails %>
    <ul id="emails">
        <li>
            <a href="mailto:$Title.HiddenEmailAddress.RAW">$Title.HiddenEmailAddress.RAW</a>
        </li>
    </ul>
    <% end_loop %>
```

# Credits

Big thank you to [Ralph Slooten](https://github.com/axllent) for the inspiration.
