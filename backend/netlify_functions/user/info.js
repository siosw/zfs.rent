const {Pool} = require("pg");
const pool = new Pool({connectionString: process.env.PG_URL});
const {pg_netlify_functions_log} = require("../lib/helper"); 

exports.handler = async function (event, context) {
  pg_netlify_functions_log(event, context);

  let res;
  try {
    res = (await pool.query('select version()')).rows[0];
  } catch (e) {
    res = String(e);
  }

  return {
    statusCode: 200,
    headers: {'content-type': 'application/json'},
    body: JSON.stringify({res, git: process.env.COMMIT_REF})
  };
}
