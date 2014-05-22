<refentry id="{@id}">
  <refnamediv>
    <refname>SearchPage class description</refname>
    <refpurpose></refpurpose>
  </refnamediv>
  <refsynopsisdiv>
    <author>papaya Software GmbH</author>
  </refsynopsisdiv>
  {@toc}
  <refsect1 id="{@id search-page}">
    <title>Introduction</title>
    <para>
      The livesearch page class extends the papaya {@link base_content} class and is used to generate 
      the specific outpout needed by a suggestion functionality.
    </para>
    <para>
      The logic is encapsulated in the {@link SearchPageBase} class, which is loaded via
      dependancy injection to ensure that the logic can easily be substituted.
    </para>
  </refsect1>
  <refsect1 id="{@id class-member}">
    <title>Class member</title>
    <para>
      This section includes the description of the class members.
    </para>
    <refsect2>
      <title>$preview</title>
      <para>
        This is a boolean parameter indicating if a backend preview is available. If you want to
        have a backend preview the parameter must be set to TRUE, otherwise FALSE.
      </para>
    </refsect2>
    <refsect2>
      <title>$paramName</title>
      <para>
        The attribute <literal>$paramName</literal> is used to identify the modules data in 
        requests by its stored value.
      </para>
    </refsect2>
  </refsect1>
  <refsect1 id="{@id class-methods}">
    <title>Class methods</title>
    <para>
      The class only uses standard methods and structures. All methods are self descriptive. 
    </para>
  </refsect1>
</refentry>