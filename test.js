const fs      = require('fs');
const path    = require('path');
const {execSync} = require('child_process')
const red     = "\x1b[31m"
const cyan    = '\x1b[36m%s\x1b[0m';
// const themes  = [];
const plugins = [{
    name:'MP lock content',
    dir: './'
}];


const dirsToExclude  = ['assets', 'node_modules', 'view', 'Views', 'views'];
const filesToExclude = [];

const lineNumbers = (needle, haystack) => haystack
    .split(/^/gm)
    .map((v, i) => v.match(needle) ? i + 1 : 0)
    .filter(a => a);

function readDir(dirPath){
    const files = fs.readdirSync(dirPath);
    files.forEach((file) => {

      const filePath = path.join(dirPath, file);
      const fileStats = fs.statSync(filePath);
      const dirName = path.dirname(filePath);

      // if not directory
      if (fileStats.isDirectory()) {
        readDir(filePath)
        return;
      }

      // Files to excludes
      if(filesToExclude.some(f => f === file )){
        return;
      }

      // Directories to excludes
      if(dirsToExclude.some(dir => dirName.includes(dir))){
        return;
      }

      // if not PHP
      if(path.extname(filePath) !== '.php'){
        return;
      }

      if(file === 'dev-mode.php'){
        return;
      }
      
      const content  = fs.readFileSync(filePath, 'utf8');
      const fullPath = filePath;


      // check 1
      try{
        execSync(`php -l ${filePath}`)
      }catch(err){
        console.log(red,`Filed: ${fullPath}`);
        console.log(err.toString())
        process.exit(1);
      }

      // check 2 
      const hasElse = lineNumbers('else',content);
      if(hasElse.length > 0){
        console.error(red, `Failed: ${fullPath} \n Please avoid using "else" at line ${hasElse[0]}`);
        console.error('\x1b[4m',`https://github.com/piotrplenik/clean-code-php#avoid-nesting-too-deeply-and-return-early-part-1`);
        process.exit(1);
      }
      
      // check 3
      if (!content.split('\n')[0]) {
        console.error(red,'Failed')
        console.error(red, `File: ${fullPath} \n Please avoid starting with an empty line`);
        process.exit(2);
      }


      // check 4 
      let hasDebugCode = lineNumbers('^dd\\(', content);
      if(hasDebugCode.length > 0){
        console.error(red, `Failed: ${fullPath} \n Please remove debug function "dd()" at line ${hasDebugCode[0]}`);
        process.exit(1);
      }

      // check 5 
      let hasVarDump = lineNumbers('var_dump\\(',content);
      if(hasVarDump.length > 0){
        console.error(red, `Failed: ${fullPath} \n Please remove debug function "var_dump()" at line ${hasVarDump[0]}`);
        process.exit(1);
      }

      // check 6 
      let hasPrintR = lineNumbers('print_r\\(',content);
      if(hasPrintR.length > 0){
        console.error(red, `Failed: ${fullPath} \n Please remove debug function "print_r()" at line ${hasPrintR[0]}`);
        process.exit(1);
      }

      // check 7 
      let hastmk = lineNumbers('TMK',content);
      if(hastmk.length > 0){
        console.error(red, `Failed: ${fullPath} \n Please remove tmk text at line ${hastmk[0]}`);
        process.exit(1);
      }

      // check 8
      let hasTMK = lineNumbers('tmk',content);
      if(hasTMK.length > 0){
        console.error(red, `Failed: ${fullPath} \n Please remove tmk text at line ${hasTMK[0]}`);
        process.exit(1);
      }
      

    });
}


const checks = [];

// Test themes
// themes.forEach(theme=>{
//     readDir('wp-content/themes/'+theme);
//     checks.push(theme + ' theme')
// })

// Test plugins
plugins.forEach(plugin=>{
    readDir(plugin.dir);
    checks.push(plugin.name)
})

checks.forEach(ch=>{
    console.log(cyan, 'Finished testing ' + ch )
})
console.log(cyan, 'All checks passed!');