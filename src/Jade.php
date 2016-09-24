<?php

namespace Slim\Views;

use \Pug\Pug as Engine;
use Psr\Http\Message\ResponseInterface;

class Jade implements \ArrayAccess
{
    protected $parserInstance; //Instance of the Jadeparser
    protected $parserOptions = array();
    protected $templatePath = "";
    protected $defaultVariables = [];
	
    /**
       * Create new Twig view
       *
       * @param string $path     Path to templates directory
       * @param array  $settings Twig environment settings
       */
      public function __construct($path, $settings = [])
      {
          $this->templatePath 	= $path;
          $this->parserOptions 	= $settings;
      }
	
    /**
     * Render Jade Template
     *
     * This method will output the rendered template content
     *
     * @param string $template The path to the Jade template, relative to the Jade templates directory.
     * @param null $data
     * @return string
     */
    public function render(ResponseInterface $response, $template, $data = [])
    {
        $env = $this->getInstance();
        $templatePathname = $this->templatePath . DIRECTORY_SEPARATOR . $template;
        
        if (!is_file($templatePathname)) {
            throw new \RuntimeException("View cannot render `$template` because the template does not exist");
        }

        $data = array_merge($this->defaultVariables, $data);
        extract($data);

        $response->getBody()->write($env->render($templatePathname, $data));
        return $response;
		
    }
    
    /**
     * Creates new Engine if it doesn't already exist, and returns it.
     *
     * @return \Engine
     */
    public function getInstance()
    {
        if (!$this->parserInstance) {

            $this->parserInstance = new Engine($this->parserOptions);
        }

        return $this->parserInstance;
    }
	
    /********************************************************************************
    * ArrayAccess interface
    *******************************************************************************/

    /**
    * Does this collection have a given key?
    *
    * @param  string $key The data key
    *
    * @return bool
    */
   public function offsetExists($key)
   {
       return array_key_exists($key, $this->defaultVariables);
   }
   /**
    * Get collection item for key
    *
    * @param string $key The data key
    *
    * @return mixed The key's value, or the default value
    */
   public function offsetGet($key)
   {
       return $this->defaultVariables[$key];
   }
   /**
    * Set collection item
    *
    * @param string $key   The data key
    * @param mixed  $value The data value
    */
   public function offsetSet($key, $value)
   {
       $this->defaultVariables[$key] = $value;
   }
   /**
    * Remove item from collection
    *
    * @param string $key The data key
    */
   public function offsetUnset($key)
   {
       unset($this->defaultVariables[$key]);
   }
   /********************************************************************************
    * Countable interface
    *******************************************************************************/
   /**
    * Get number of items in collection
    *
    * @return int
    */
   public function count()
   {
       return count($this->defaultVariables);
   }
   /********************************************************************************
    * IteratorAggregate interface
    *******************************************************************************/
   /**
    * Get collection iterator
    *
    * @return \ArrayIterator
    */
   public function getIterator()
   {
       return new \ArrayIterator($this->defaultVariables);
   }	
}


?>
