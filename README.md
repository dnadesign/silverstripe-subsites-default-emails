# SilverStripe Subsites Default Emails

This module adds a DefaultFromEmail field to the Subsite DataObject which can be used to set the default "From" address for emails sent from each subsite. 

The main site will still use the config value that has been set in you application config:

`
SilverStripe\Control\Email\Email:
  admin_email: no-reply@mysite.nz
`

If a subsite does not have a value set for DefaultFromEmail then the value of 'admin_email' will be used. 

Note: this functionality does not affect any emails that have explicitly set the from address when sending an email, only emails that do not have any from address set.

## Limititations

This functionality will not work via the command line or anywhere that Subsite::currentSubsite() returns null.
