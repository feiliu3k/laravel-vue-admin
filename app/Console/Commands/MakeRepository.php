<?php


namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;


class MakeRepository extends Command
{

    protected $signature = 'make:repository
                             {name : repository name}
                             {--model= : model name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new repository';


    protected $files;

    protected $composer;

    protected $model;

    protected $repository;

    public function __construct(Filesystem $filesystem, Composer $composer)
    {
        parent::__construct();

        $this->files = $filesystem;
        $this->composer = $composer;

    }

    /**
     * @param mixed $repository
     */
    public function setRepository($repositoryName)
    {
        $name = strtolower($repositoryName);
        $name=str_replace(".","_",$name);
        $name=str_replace("repository","",$name);
        $this->repository = $name;
    }

    private function getRepository()
    {
        $names = explode('_',$this->repository);
        $result = "";
        foreach ( $names as $item){
            $result.=ucfirst($item);
        }

        return $result;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    private function getModel()
    {
        $name = strtolower($this->model);
        return ucfirst($name);

    }

    private function getModelName()
    {
        $modelName = $this->getModel();
        if ( isset( $modelName ) && ! empty( $modelName ) ) {
            $modelName = ucfirst( $modelName );
        } else {
            // 若option选项没写,则根据repository来生成Model Name
            $modelName = $this->getModelFromRepository();
        }

        return $modelName;
    }

    private function getModelFromRepository()
    {
        $names = explode('_',$this->repository);
        return ucfirst($names[0]);
    }


    private function getInterfaceName()
    {
        return $this->getRepositoryName() . 'Interface';
    }



    private function getRepositoryName() {

        return $this->getRepository(). 'Repository';;
    }


    private function getDirectory()
    {
        $path = Config::get('repository.directory_path');
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }
        return $path;
    }

    private function templateStub()
    {
        // 获取两个模板文件
        $stubs = [
            'Repository' => $this->files->get(__DIR__ . DIRECTORY_SEPARATOR . 'stub' . DIRECTORY_SEPARATOR . 'Repository.stub'),
            'Interface' => $this->files->get(__DIR__ . DIRECTORY_SEPARATOR . 'stub' . DIRECTORY_SEPARATOR . 'RepositoryInterface.stub'),
        ];
        // 获取需要替换的模板文件中变量
        $templateData = $this->getTemplateData();

        $renderStubs = [];
        foreach ($stubs as $key => $stub) {
            // 进行模板渲染
            $renderStubs[$key] = $this->getRenderStub($templateData, $stub);
        }

        return $renderStubs;
    }

    private function getTemplateData()
    {
        $repositoryNamespace          = Config::get( 'repository.repository_namespace' );
        $modelNamespace               = 'App\Models\\' . $this->getModelName();
        $repositoryInterfaceNamespace = Config::get( 'repository.repository_interface_namespace' );
        $repositoryInterface          = $this->getInterfaceName();
        $className                    = $this->getRepositoryName();
        $modelName                    = $this->getModelName();

        $templateVar = [
            'repository_namespace'           => $repositoryNamespace,
            'model_namespace'                => $modelNamespace,
            'repository_interface_namespace' => $repositoryInterfaceNamespace,
            'repository_interface'           => $repositoryInterface,
            'class_name'                     => $className,
            'model_name'                     => $modelName,
            'model_var_name'                 => strtolower( $modelName ),
        ];

        return $templateVar;
    }

    private function getRenderStub($templateData, $stub)
    {
        foreach ($templateData as $search => $replace ) {
            $stub = str_replace( '$' . $search, $replace, $stub );
        }

        return $stub;
    }

    private function getPath($class)
    {
        // 两个模板文件,对应的两个路径
        $path = null;
        switch ( $class ) {
            case 'Repository':
                $path = $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getRepositoryName() . '.php';
                break;
            case 'Interface':
                $path = $this->getInterfaceDirectory() . DIRECTORY_SEPARATOR . $this->getInterfaceName() . '.php';
                break;
        }

        return $path;
    }
    private function getInterfaceDirectory()
    {
        $path = Config::get( 'repository.directory_interface_path' );
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }
        return $path;
    }



    public function handle()
    {
        $this->setRepository($this->argument('name'));
        $this->setModel($this->option('model'));
        $this->writeRepositoryAndInterface();
        $this->writeRepositoryService( );
    }

    private function writeRepositoryAndInterface()
    {
        $repositoryName = $this->getRepository();
        $directory = $this->getDirectory();
        $templates = $this->templateStub();
        $class = null;
        foreach ($templates as $key => $template) {
            //根据不同路径,渲染对应的模板文件
            if (!$this->files->exists($this->getPath($key))) {
                $class = $this->files->put($this->getPath($key), $template);
            }
        }
        if ( $class) {
            //若生成成功,则输出信息
            $this->info( 'Success to make a ' . ucfirst( $repositoryName ) . ' Repository and a ' . ucfirst( $repositoryName ) . 'Interface Interface' );
        }else{
            $this->error( 'fail to make a ' . ucfirst( $repositoryName ) . ' Repository and a ' . ucfirst( $repositoryName ) . 'Interface Interface' );
        }



    }


    private function writeRepositoryService()
    {
        $directory = $this->getDirectory();
        $files = $this->files->files($directory);
        $strData="\n    ";
        if(count($files)<0){
            return false;
        }
        foreach ($files as $file ) {
            $className =basename($file);
            $className = substr($className,0,strlen($className)-4) ;
            $classSpaceName = Config::get( 'repository.repository_namespace' )."\\".$className;

            $interfaceName = Config::get( 'repository.repository_interface_namespace' )."\\".$className."Interface";
            $strBind = sprintf('$this->app->bind(\'%s\',\'%s\');',$interfaceName,$classSpaceName);
            $strData=$strData.$strBind."\n    ";
        }
        $template = $this->files->get( __DIR__ . DIRECTORY_SEPARATOR . 'stub' . DIRECTORY_SEPARATOR . 'ServiceProvider.stub' );
        $template = $this->getRenderStub(['all_class'=>$strData],$template);
        $providers_path = Config::get( 'repository.providers_path' );
        $this->files->put( $providers_path, $template );
    }

}