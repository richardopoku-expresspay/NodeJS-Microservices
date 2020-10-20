const bodyParser = require('body-parser');
const cors = require('cors');
const express = require('express');

import accessEnv from "#root/helpers/accessEnv";

const PORT = accessEnv('PORT', 7100);

const app = express();

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.use(cors({
    origin: (origin, callback) => callback(null, true),
    credentials: true,
}));

app.listen(PORT, () => {
    console.log("Listings service listening on : ".PORT);
});