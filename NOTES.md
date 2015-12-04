# NOTES.md

- The server hosting the test is an **old** **t1.micro** AWS instance, not
suitable for any form of production (see
http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/concepts_micro_instances.html
for details): CPU, IO and Network starvation problems are notorious for that
class of instances. So if any performance problem is perceived during the test
take into account the server used.

- The contact search was implemented using MySQL 5.6's Full text search in
Boolean mode and it have its advantages and disadvantages, a simpler LIKE will
have more predictable behaviour but will lack in scalability as the contact
table grows. If the LIKE search is preferable its a **simple and fast** change.

- ActiveCampaign API requires a LIST for every contact, the original scope was
not specific about it so I've created one list using the AC web interface and
used it statically hand-coded in the API calls.

- ActiveCampaign API requires the emails in a list to be unique, so as I'm
using one fixed list with all AC API calls, this are rendering the contacts
interface in the TEST quite useless because the email in the contacts table
needs to be unique regardless of the user owner of the contact. This **can be
fixed** using one list per Authenticated User.

- As the original scope demanded, end-user performance was paramount, so I've
implemented **all the ActiveCampaign API calls behind a async interface using a
Worker Queue**. The end user **never** waits for a API call completion. **But**
the api calls are made a short time (seconds) after the event has taken place,
asynchronously.

- The user id is **never** passed in GET or POST calls in the Contacts pages,
all contact pages are **Auth-only** and all Contacts operations **check for the
correct User owner ID**.

- *To my knowledge* (I didn't retested all queries in the end) all queries are
sane and indexed (that simple 2 models in a one-to-many relationship are in the
**3rd normal form**).

- To account for front-end components of the test I've used **gulp** to compile
SASS, copy and concatenate javascript and css files.

- The composer packages been used are:

```
    "require": {
        "laravel/framework": "4.2.*",
        "components/jquery": "^2.1",
        "artdarek/oauth-4-laravel": "dev-master",
        "pda/pheanstalk": "~2.1",
        "evodelavega/activecampaign-api-php": "dev-master",
        "cebe/markdown": "^1.1"
    },
```
- **Mysql 5.6** is a minimum requirement because of the FTS in InnoDB tables used
in the search.

- For the queue Ive used **beanstalkd** queue system.

- The ActiveCampaign API appears to be quite fragile, to say the least.


Any doubts (or errors found) please contact me.
