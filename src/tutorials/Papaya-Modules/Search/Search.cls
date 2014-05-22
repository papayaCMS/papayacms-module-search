<refentry id="{@id}">
  <refnamediv>
    <refname>Description for the Search class</refname>
    <refpurpose>The Search enhances a HTML input field to a live search field.</refpurpose>
  </refnamediv>
  <refsynopsisdiv>
    <author>papaya Software GmbH</author>
  </refsynopsisdiv>
  {@toc}
  <refsect1 id="{@id search}">
    <title>Introduction</title>
    <para>
      The Search represents a type ahead search like 'Google suggest'. In this perticular 
      case it provides the ability to lookup a zipCode by a name or a substring of a name of a city.
    </para>
  </refsect1>
  <refsect1 id="{@id class-member}">
    <title>Class member</title>
    <para>
      This section includes the description of the class members.
    </para>
    <refsect2 id="{@id class-member-dataprovider}">
      <title>$_dataprovider</title>
      <para>
        The private class member <literal>$_dataprovider</literal> shall keep the instance of a
        dataprovider object based on the {@link SearchInterfaceDataprovider} interface 
        (read the tutorial of the 
        {@tutorial Search/SearchInterfaceDataprovider.cls} for further 
        information).
      </para>
    </refsect2>
  </refsect1>
  <refsect1 id="{@id class-methods}">
    <title>Class methods</title>
    <para>
      This section includes the extensive description of the class methods. 
    </para>
    <refsect2 id="{@id class-methods-validateinput}">
      <title>validateInput( $searchString )</title>
      <para>
        The {@link Search::validateInput()} method checks the user-input against the expectations
        of the loaders searching for the term provided by the user. It returns <literal>TRUE</literal>
        if the tests were passed or <literal>FALSE</literal> if just one of the defined checks fails.
      </para>
    </refsect2>
    <refsect2 id="{@id class-methods-searchXml}">
      <title>searchXML()</title>
      <para>
        The {@link Search::searchXml()} method passes the user provided search string after 
        a validation (see {@link Search::validateInput()}).
      </para>
    </refsect2>
    <refsect2 id="{@id class-methods-getXml}">
      <title>getXml()</title>
      <para>
        The {@link Search::getXml()} method trancodes the search result provided as an array
        into a defined XML strukture.
      </para>
      <para>
        This strukture is defined as follows:
        <programlisting role="xml">
          &lt;?xml version="1.0" encoding="utf-8" standalone="yes"?&gt;
&lt;response xmlns="http://www.w3.org/1999/xhtml"&gt;
  &lt;items query="&lt;SEARCHSTRING&gt;" limit="&lt;SEARCHLIMIT&gt;" offset="&lt;SEARCHOFFSET&gt;"&gt;
    [&lt;item&gt;&lt;RESULTITEMVALUE&gt;&lt;/item&gt;
    [...]]
  &lt;/items&gt;
&lt;/response&gt;
        </programlisting>
      </para>
      <para>
        The generic XML structure of the resopnse as shown above may not contain any 'item'-nodes.
        This happens if there was nothing found matching the search string.
        The 'limit' attribute contains the number of shown 'item'-nodes and shall be set by 
        the instance of the dataprovider.
      </para>
    </refsect2>
    <refsect2 id="{@id class-methods-setDataprovider}">
      <title>setDataprovider()</title>
      <para>
        The {@link Search::setDataprovider()} method is one part of a dependency injection to
        override a probaly already instantiated dataprovider object.
      </para>
    </refsect2>
    <refsect2 id="{@id class-methods-getDataprovider}">
      <title>getDataprovider()</title>
      <para>
        The {@link Search::getDataprovider()} method uses the lazy initialization methodology
        to return an instance of a dataprovider. The initial instantiation of a new dataprovider can 
        be suppressed by using the {@link Search::setDataprovider()} in front. 
        This might be used for unittests or other situations an other dataprovider shall be returned.
      </para>
    </refsect2>
  </refsect1>
</refentry>