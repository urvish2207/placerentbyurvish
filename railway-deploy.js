#!/usr/bin/env node
/**
 * PlaceRent - Railway Deployment Script
 * Uses Railway GraphQL API to create project, add MySQL, and link GitHub repo
 * 
 * Usage: node railway-deploy.js <RAILWAY_API_TOKEN>
 * Get token from: https://railway.app/account/tokens
 */

const https = require('https');

const RAILWAY_TOKEN = process.env.RAILWAY_TOKEN || process.argv[2];

if (!RAILWAY_TOKEN) {
    console.error('❌ RAILWAY_TOKEN is required!');
    console.error('   Get it from: https://railway.app/account/tokens');
    console.error('   Usage: node railway-deploy.js <YOUR_TOKEN>');
    process.exit(1);
}

const GITHUB_REPO = 'urvish2207/placerentbyurvish';
const APP_NAME = 'placerent';
const DB_NAME = 'placerent';

function graphqlRequest(query, variables = {}) {
    return new Promise((resolve, reject) => {
        const data = JSON.stringify({ query, variables });
        const options = {
            hostname: 'backboard.railway.app',
            port: 443,
            path: '/graphql/v2',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${RAILWAY_TOKEN}`,
                'Content-Length': Buffer.byteLength(data),
            },
        };

        const req = https.request(options, (res) => {
            let body = '';
            res.on('data', chunk => body += chunk);
            res.on('end', () => {
                try {
                    const parsed = JSON.parse(body);
                    if (parsed.errors) {
                        reject(new Error(parsed.errors[0].message));
                    } else {
                        resolve(parsed.data);
                    }
                } catch (e) {
                    reject(new Error(`Failed to parse response: ${body}`));
                }
            });
        });

        req.on('error', reject);
        req.write(data);
        req.end();
    });
}

async function deploy() {
    console.log('🚀 Starting PlaceRent deployment to Railway...\n');

    // Step 1: Create project
    console.log('📦 Step 1: Creating Railway project...');
    const projectData = await graphqlRequest(`
        mutation CreateProject($input: ProjectCreateInput!) {
            projectCreate(input: $input) {
                id
                name
            }
        }
    `, {
        input: {
            name: APP_NAME,
            description: 'PlaceRent - Space Rental Platform'
        }
    });
    const projectId = projectData.projectCreate.id;
    console.log(`   ✅ Project created: ${projectData.projectCreate.name} (${projectId})\n`);

    // Step 2: Get environment ID
    console.log('🌍 Step 2: Getting production environment...');
    const envData = await graphqlRequest(`
        query GetProject($id: String!) {
            project(id: $id) {
                environments {
                    edges {
                        node { id name }
                    }
                }
            }
        }
    `, { id: projectId });
    const environmentId = envData.project.environments.edges[0].node.id;
    console.log(`   ✅ Environment: ${envData.project.environments.edges[0].node.name} (${environmentId})\n`);

    // Step 3: Add MySQL database service
    console.log('🗄️  Step 3: Creating MySQL database service...');
    const dbData = await graphqlRequest(`
        mutation CreateMysql($projectId: String!, $environmentId: String!) {
            serviceCreate(input: {
                projectId: $projectId,
                name: "mysql-db",
                source: { image: "mysql:8.0" }
            }) {
                id
                name
            }
        }
    `, { projectId, environmentId });
    const dbServiceId = dbData.serviceCreate.id;
    console.log(`   ✅ MySQL service created: ${dbServiceId}\n`);

    // Step 4: Create GitHub deployment service
    console.log('🔗 Step 4: Linking GitHub repository...');
    const appData = await graphqlRequest(`
        mutation CreateService($projectId: String!, $repoName: String!) {
            serviceCreate(input: {
                projectId: $projectId,
                name: "placerent-app",
                source: {
                    repo: $repoName
                }
            }) {
                id
                name
            }
        }
    `, { 
        projectId, 
        repoName: GITHUB_REPO 
    });
    const appServiceId = appData.serviceCreate.id;
    console.log(`   ✅ App service created: ${appServiceId}\n`);

    // Step 5: Set environment variables
    console.log('⚙️  Step 5: Setting environment variables...');
    const envVars = {
        APP_NAME: 'PlaceRent',
        APP_ENV: 'production',
        APP_DEBUG: 'false',
        APP_KEY: 'base64:o54dlIjHPGG/6o5kCB2S7SxE+qexS8W7tPiusGfUWkE=',
        APP_URL: 'https://placerent-app.up.railway.app',
        LOG_CHANNEL: 'stderr',
        LOG_LEVEL: 'error',
        DB_CONNECTION: 'mysql',
        DB_HOST: '${{mysql-db.MYSQL_HOST}}',
        DB_PORT: '${{mysql-db.MYSQL_PORT}}',
        DB_DATABASE: 'railway',
        DB_USERNAME: '${{mysql-db.MYSQL_USER}}',
        DB_PASSWORD: '${{mysql-db.MYSQL_PASSWORD}}',
        SESSION_DRIVER: 'database',
        QUEUE_CONNECTION: 'database',
        CACHE_STORE: 'database',
        FILESYSTEM_DISK: 'public',
        MAIL_MAILER: 'smtp',
        MAIL_HOST: 'sandbox.smtp.mailtrap.io',
        MAIL_PORT: '587',
        MAIL_USERNAME: '19bef8702c99a1',
        MAIL_PASSWORD: '039e0e5b9b0574',
        MAIL_ENCRYPTION: 'tls',
        MAIL_FROM_ADDRESS: 'mistriurvish@gmail.com',
        MAIL_FROM_NAME: 'PlaceRent',
        STRIPE_KEY: process.env.STRIPE_KEY || 'YOUR_STRIPE_PUBLISHABLE_KEY',
        STRIPE_SECRET: process.env.STRIPE_SECRET || 'YOUR_STRIPE_SECRET_KEY',
    };

    for (const [name, value] of Object.entries(envVars)) {
        await graphqlRequest(`
            mutation SetVar($projectId: String!, $environmentId: String!, $serviceId: String!, $name: String!, $value: String!) {
                variableUpsert(input: {
                    projectId: $projectId,
                    environmentId: $environmentId,
                    serviceId: $serviceId,
                    name: $name,
                    value: $value
                })
            }
        `, { projectId, environmentId, serviceId: appServiceId, name, value });
        process.stdout.write('.');
    }
    console.log('\n   ✅ Environment variables set!\n');

    console.log('\n🎉 Deployment initiated successfully!');
    console.log('━'.repeat(60));
    console.log(`📦 Project ID:   ${projectId}`);
    console.log(`🌐 App URL:      https://placerent-app.up.railway.app`);
    console.log(`🗄️  Database:     MySQL (Railway managed)`);
    console.log('\n📋 Next steps:');
    console.log('   1. Visit https://railway.app/dashboard to monitor deployment');
    console.log('   2. Wait ~3-5 minutes for build to complete');
    console.log('   3. Your app will be live at the URL above!');
    console.log('━'.repeat(60));
}

deploy().catch(err => {
    console.error('❌ Deployment failed:', err.message);
    process.exit(1);
});
