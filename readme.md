Hello, Sergio.

Thank you for completing the one-way interview.  It sounds like you may be a
good fit for our Laravel developer position!

We have found that the best way to evaluate our developers is to give them a
simple coding project that verifies one's understanding of Laravel and Boostrap
"best practice" standards.  If you're up to the task, read on!

You'll use a very basic design using any pre-built bootstrap framework template.
Please use standard jQuery for the javascript functions.
Needless to say, cleanness and efficiency in the code is required.  This test
needs to be coded with Laravel 4.2 and Bootstrap 3.

Here's the test:

Create a simple name+email registration/login page, with GitHub / FaceBook
connect buttons (the facebook ID of the test evaluator is hector.yague.14).
Users signing up will be added into a database.

Upon login, users will see a Contacts Page with the list of contacts within
their account.  Obviously, at the beginning that list will be empty, so you will
add an Add Contact button.

Also, in the main Contact Page there should be a search box so the account user
can search through contacts by email, surname or phone.

When they create (or edit) a contact a modal window should pop up: other than
the typical Name, Surname, Email and Phone fields, let's also display in a modal
window with the contact's details plus the account admin can add up to 5 extra
custom fields to that contact: The extra fields should not have a name, just an
input field to type in the value. Those custom fields will be added one by one
with a "+" button, and we should be able to delete each of them by adding a "-"
button next to each custom field.

Please mind that the custom fields are not global for all contacts - instead,
they're unique to each specific contact.

Upon creating a new contact or editing an existing contact, the Contacts Page
updates without refreshing the page.

When a contact is created or edited, the contact details needs to be added to
ActiveCampaign via the ActiveCampaign API. You will find their API information
in their database.

You can create a dummy 30-day trial Active Campaign account in order to test if
your API connection worked as it should. We will need access to that trial
account to confirm the test.

Important:

1) Please pay special attention into database structure and efficiency, as well
as making sure security protocols are ensured to avoid potential breaches into
the database, or into the account login, or stealing contacts from other
accounts. That means that one user should not be able to access other people's
contact list.

2) Please make sure every action in the console is passed to ActiveCampaign:
creating a new contact, editing the details, deleting the contact, etc.

3) It's important that the queries to the database and to the ActiveCampaign API
are lightning fast, so please code database and API queries as efficiently as
possible. The experience of creating, editing, deleting or searching for a
contact should be almost instant.

What to do with it:

When you have finished coding the application, please push it to a dummy server
and provide me with a login.  This way I can see your deployment methods.

Please don't hesitate to contact me if you have any questions.

Thank you very much and GOOD LUCK!
--
Gideon Marcus
Director of Operations
Genesis Digital, LLC
