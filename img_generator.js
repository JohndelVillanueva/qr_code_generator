const puppeteer = require('puppeteer');
const axios = require('axios');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    await page.setViewport({ width: 610, height: 800});
    const htmlResponse = await axios.get('http://localhost/qr_code_generator/ticket.php');
    const htmlContent = htmlResponse.data;


    await page.setContent(htmlContent, {waitUntil: 'domcontentloaded'});

await page.waitForSelector('img');

const element = await page.$('.ticket-wrapper');
await element.screenshot({path: 'images/screenshot.png'});
await browser.close();
})();