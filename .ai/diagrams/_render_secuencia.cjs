const puppeteer = require('puppeteer');
const path = require('path');

(async () => {
  const browser = await puppeteer.launch({
    headless: 'new',
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });
  const page = await browser.newPage();
  const htmlPath = path.resolve('/home/willian/workspace/incos/tercerAnio/web3/HMIGU1/.ai/diagrams/entrega-secuencia/diagramas-secuencia.html');
  await page.goto('file://' + htmlPath, { waitUntil: 'networkidle0', timeout: 60000 });
  await page.emulateMediaType('print');
  await page.pdf({
    path: '/home/willian/workspace/incos/tercerAnio/web3/HMIGU1/.ai/diagrams/entrega-secuencia/diagramas-secuencia.pdf',
    format: 'A4',
    printBackground: true,
    margin: { top: '15mm', bottom: '15mm', left: '15mm', right: '15mm' }
  });
  await browser.close();
  console.log('PDF generado');
})();
