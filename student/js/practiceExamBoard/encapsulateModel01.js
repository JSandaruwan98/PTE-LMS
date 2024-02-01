// module1.js
const myModule = (function () {

    const ajaxManager = new AJAXManager();
    
  
    return {
      ajaxManager,
    };
  })();
  
  export default myModule;
  