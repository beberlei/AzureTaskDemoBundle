# Azure TaskDemo Bundle

This bundle demonstrates functionality of Windows Azure in combination with Symfony and Doctrine.

This works in combination with [Azure Distribution Bundle](https://github.com/beberlei/AzureDistributionBundle).

## Installing the Task Demo Bundle

1. Downlad from https://github.com/beberlei/AzureTaskDemoBundle
2. Unzip files into src\WindowsAzure\TaskDemoBundle
3. Add 'new WindowsAzure\TaskDemoBundle\WindowsAzureTaskDemoBundle()' into the `$bundles` array. 
4. Configure the database by modifying `app\config\azure_parameters.yml`.

An example of the `azure_parameters.yml` looks like:

    # Put Azure Specific configuration parameters into
    # this file. These will overwrite parameters from parameters.yml
    parameters:
        session_type: pdo
        database_host: tcp:DBID.database.windows.net
        database_user: USER@DBID
        database_password: PWD
        database_name: DBNAME

5. Configure Security

Open `app\config\security.yml` and exchange the line:

    - { resource: security.yml }

with the following line: 

    - { resource: ../../src/WindowsAzure/TaskDemoBundle/Resources/config/security.yml }

6. Import the contents of the "schema.sql" from src\WindowsAzure\TaskDemoBundle\Resources\schema.sql into your SQL Azure database.

