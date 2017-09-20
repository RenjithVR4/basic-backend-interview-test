<?php

/* @Twig/Exception/exception.json.twig */
class __TwigTemplate_45daeab719eca822b60a0863a1c4978ba017746e76c7819e4068894fc961f623 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_7db886474dbb84e1f1d71dfc8d1234d9d234a0bbbc7d0cca2212cf6e235904a4 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_7db886474dbb84e1f1d71dfc8d1234d9d234a0bbbc7d0cca2212cf6e235904a4->enter($__internal_7db886474dbb84e1f1d71dfc8d1234d9d234a0bbbc7d0cca2212cf6e235904a4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.json.twig"));

        $__internal_c0f6b74c58c0dfb0b7c52fd56e3535c81e07265711d21acc549dc6cd5b420bde = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_c0f6b74c58c0dfb0b7c52fd56e3535c81e07265711d21acc549dc6cd5b420bde->enter($__internal_c0f6b74c58c0dfb0b7c52fd56e3535c81e07265711d21acc549dc6cd5b420bde_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.json.twig"));

        // line 1
        echo json_encode(array("error" => array("code" => (isset($context["status_code"]) || array_key_exists("status_code", $context) ? $context["status_code"] : (function () { throw new Twig_Error_Runtime('Variable "status_code" does not exist.', 1, $this->getSourceContext()); })()), "message" => (isset($context["status_text"]) || array_key_exists("status_text", $context) ? $context["status_text"] : (function () { throw new Twig_Error_Runtime('Variable "status_text" does not exist.', 1, $this->getSourceContext()); })()), "exception" => twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["exception"]) || array_key_exists("exception", $context) ? $context["exception"] : (function () { throw new Twig_Error_Runtime('Variable "exception" does not exist.', 1, $this->getSourceContext()); })()), "toarray", array()))));
        echo "
";
        
        $__internal_7db886474dbb84e1f1d71dfc8d1234d9d234a0bbbc7d0cca2212cf6e235904a4->leave($__internal_7db886474dbb84e1f1d71dfc8d1234d9d234a0bbbc7d0cca2212cf6e235904a4_prof);

        
        $__internal_c0f6b74c58c0dfb0b7c52fd56e3535c81e07265711d21acc549dc6cd5b420bde->leave($__internal_c0f6b74c58c0dfb0b7c52fd56e3535c81e07265711d21acc549dc6cd5b420bde_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception.json.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{{ { 'error': { 'code': status_code, 'message': status_text, 'exception': exception.toarray } }|json_encode|raw }}
", "@Twig/Exception/exception.json.twig", "/var/www/html/tests/basic-backend-interview-test/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle/Resources/views/Exception/exception.json.twig");
    }
}
