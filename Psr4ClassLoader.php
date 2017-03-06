<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS ``AS IS''
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR
 * BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
 * OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN
 * IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * (c) Paulus Gandung Prakosa (gandung@ppp.cylab.cmu.edu)
 */

class Psr4ClassLoader
{
	/**
	 * An associative array where the key is a namespace prefix and the value
	 * is an array of base directories for classes in that namespace.
	 *
	 * @var array
	 */
	protected $prefixes = array();

	/**
	 * {@singleton}
	 */
	public static function create()
	{
		return new static;
	}

	/**
	 * Register loader with SPL autoloader stack.
	 *
	 * @return void
	 */
	public function register()
	{
		spl_autoload_register(array($this, 'loadClass'));
	}

	/**
	 * Adds a base directory for a namespace prefix.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $base_dir A base directory for class files in the namespace.
	 * @param bool $prepend If true, prepend the base directory to the stack instead
	 * of appending it; this causes it to be searched first rather than last.
	 *
	 * @return void
	 */
	public function addNamespace($prefix, $baseDir, $prepend = false)
	{
		/**
		 * Normalize namespace prefix.
		 */
		$prefix = trim($prefix, '\\') . '\\';

		/**
		 * Normalize the base directory with a trailing separator.
		 */
		$baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		/**
		 * Initialize the namespace prefix array.
		 */
		if (isset($this->prefixes[$prefix]) === false) {
			$this->prefixes[$prefix] = array();
		}

		/**
		 * Retain the base directory for the namespace prefix.
		 */
		if ($prepend) {
			array_unshift($this->prefixes[$prefix], $baseDir);
		}
		else {
			array_push($this->prefixes[$prefix], $baseDir);
		}
	}

	/**
	 * Loads the class file for a given class name.
	 *
	 * @param string $class The fully-qualified class name.
	 * @return mixed The mapped file name on success, or boolean false on failure.
	 */
	public function loadClass($class)
	{
		/**
		 * The current namespace prefix.
		 */
		$prefix = $class;

		/**
		 * Work backwards through the namespace names of fully-qualified class
		 * name to find a mapped file name.
		 */
		while (false !== ($pos = strrpos($prefix, '\\'))) {
			/**
			 * Retain the trailing namespace separator in the prefix.
			 */
			$prefix = substr($class, 0, $pos + 1);

			/**
			 * The rest is the relative class name.
			 */
			$relativeClass = substr($class, $pos + 1);

			/**
			 * Try to load a mapped file for the prefix and relative class.
			 */
			$mappedFile = $this->loadMappedFile($prefix, $relativeClass);

			if ($mappedFile) {
				return $mappedFile;
			}

			/**
			 * Remove the trailing namespace separator for the next iteration.
			 */
			$prefix = rtrim($prefix, '\\');
		}

		return ( false );
	}

	/**
	 * Load the mapped file for a namespace prefix and relative class.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $relativeClass The relative class name.
	 * @return mixed Boolean false if no mapped file can be loaded, or the
	 * name of the mapped file that was loaded.
	 */
	protected function loadMappedFile($prefix, $relativeClass)
	{
		/**
		 * Are there any base directories for this namespace prefix?
		 */
		if (isset($this->prefixes[$prefix]) === false) {
			return ( false );
		}

		/**
		 * Look through base directories for this namespace prefix.
		 */
		foreach ($this->prefixes[$prefix] as $baseDir) {
			/**
			 * - Replace the namespace prefix with the base directory.
			 * - Replace namespace separators with directory separators
			 *	in the relative class name, append with '.php' suffix.
			 */
			$file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

			/**
			 * If the mapped file exists, require it.
			 */
			if ($this->requireFile($file)) {
				return $file;
			}
		}

		return ( false );
	}

	/**
	 * If a file exists, require it from the filesystem.
	 *
	 * @param string $file The file to require.
	 * @return bool True if the file exists, otherwise False
	 */
	protected function requireFile($file)
	{
		if (file_exists($file)) {
			/**
			 * Clear the file status cache.
			 */
			clearstatcache();

			require $file;

			return ( true );
		}

		return ( false );
	}
}
