# Azure TaskDemo Bundle

This bundle demonstrates functionality of Windows Azure in combination with Symfony and Doctrine.

This works in combination with [Azure Distribution Bundle](https://github.com/beberlei/AzureDistributionBundle).

    Notice: This bundle is still in development. Functionality to demonstrate Windows Azure features will be added incrementally.

## Installing the Task Demo Bundle

1. Downlad from https://github.com/beberlei/AzureTaskDemoBundle
2. Unzip files into src\WindowsAzure\TaskDemoBundle
3. Add `new WindowsAzure\TaskDemoBundle\WindowsAzureTaskDemoBundle()` into the `$bundles` array.
4. Configure the database by modifying `app\config\azure_parameters.yml`.

An example of the `azure_parameters.yml` looks like:

    # Put Azure Specific configuration parameters into
    # this file. These will overwrite parameters from parameters.yml
    parameters:
        session_type: pdo
        database_driver: pdo_sqlsrv
        database_host: tcp:DBID.database.windows.net
        database_user: USER@DBID
        database_password: PWD
        database_name: DBNAME

5. Configure Security

Open `app\config\security.yml` and exchange the line:

    - { resource: security.yml }

with the following line:

    - { resource: ../../src/WindowsAzure/TaskDemoBundle/Resources/config/security.yml }

6. Register routes in app\config\routing.yml

        WindowsAzureTaskDemoBundle:
            resource: "@WindowsAzureTaskDemoBundle/Controller/"
            type:     annotation
            prefix:   /


7. Import the contents of the "schema.sql" from src\WindowsAzure\TaskDemoBundle\Resources\schema.sql into your SQL Azure database.

8. Install the Doctrine sharding extension from https://github.com/doctrine/shards into "vendor/doctrine-shards".
   Add `'Doctrine\Shards' => 'vendor/doctrine-shards/lib'` to the `app\autoload.php`

## Features

### Sharding with SQL Azure

This demo uses SQL Azure Federations to show the sharding functionality. The data model looks like follows:

1. User Table (Root Database)
2. Task Table (Federated Table)
3. TaskType Table (Federation Table, but not federated)

The federation is federated on the `user_id` as distribution key. A request listener will decide which federation to use by looking at the session user object. As long as the user is not logged in, no federation will be picked.

The federations require one slight change to a perfectly normalized database schema. Instead of having a task-id on the tasks table there is a composite primary key on "taskid"+"userid".

