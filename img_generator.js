const puppeteer = require('puppeteer');
const axios = require('axios');

// Function for generate an image based on unique ID
// function generateUniqueID(){
// const timestamp = new Date().getTime();
// const random = Math.floor(Math.random() * 10000);
// return 'user'+timestamp+'_'+random+'.png';
// }

(async () => {
    try{
    //Launch
    const browser = await puppeteer.launch();
    //Initialize
    const response = await axios.get('http://localhost/qr_code_generator/qr.php');
    const page = await browser.newPage();
    //SetViewDimension
    await page.setViewport({ width: 1920, height: 953});
    //Fetch the content of ticket template.php
    const htmlResponse = await axios.get('http://localhost/qr_code_generator/ticket3.php');
    //Get Content
    const htmlContent = htmlResponse.data;
    //Set Content
    await page.setContent(htmlContent, {waitUntil: 'domcontentloaded'});
    //wait Until Loaded
    await page.waitForSelector('img');
    //Wait until Loaded
    const element = await page.$('.ticket-wrapper');
    //Variable Name

    const {first_name, last_name} = response.data;
    const filename = `${first_name}_${last_name}.png`;
    //Saves the image
    await element.screenshot({path: 'images/' + filename});
    //Take a screenshot and save to buffer
    const screenshotBuffer = await element.screenshot();

    //Send the screenshot to PHP script using Axios
    await axios.post('http://localhost/qr_code_generator/qr.php', screenshotBuffer,{
        headers: {
            'Content-Type': 'image/png',
        }
    });
        //closes the script
        await browser.close();
    console.log('screenshot ' +filename +' sent!');
} catch (error){
    console.error('Error occured:', error);
}
})();