<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE refentry PUBLIC "-//OASIS//DTD DocBook XML V4.4//EN"
  "http://www.oasis-open.org/docbook/xml/4.4/docbookx.dtd">
<refentry id="{@id}">
  <refnamediv>
    <refname>How to use and test the SearchUtilDialogBuilder class</refname>
    <refpurpose>Enable the reader to integrate the class for dialog creation.</refpurpose>
  </refnamediv>
  <refsynopsisdiv>
    <author>papaya Software GmbH</author>
  </refsynopsisdiv>
  {@toc}
  <refsect1 id="{@id search-util-dialog-builder}">
    <title>Introduction</title>
    <para>
      The SearchUtilDialogBuilder class provides a means of creating dialogs without using
      base_dialog directly. This enables classes using it to be completely tested.
    </para>
    <para>
    </para>
  </refsect1>
  <refsect1 id="{@id dialog-builder-methods}">
    <title>Methods</title>
    <para>
      This section lists and explains the class methods of <literal>SearchUtilDialogBuilder</literal>.
    </para>
    <para>
      <graphic fileref="./tutorials/Papaya-Modules/Search/figures/SearchUtilDialog.png"/>
    </para>
    <refsect2 id="{@id method-create-dialog}">
      <title>SearchUtilDialogBuilder::createDialog</title>
      <para>
      The method <literal>createDialog</literal> initializes and creates a new instance of
      <literal>base_dialog</literal>. The derived class <literal>SearchUtilDialogBasic</literal>
      is used to make it testable.
      </para>
      <para>

      </para>
    </refsect2>
    <refsect2 id="{@id method-create-msg-dialog}">
      <title>SearchUtilDialogBuilder::createMsgDialog</title>
      <para>
      The method <literal>createMsgDialog</literal> initializes and creates a new instance of
      <literal>base_msgdialog</literal>. The derived class <literal>SearchUtilDialogMessage</literal>
      is used to make it testable.
      </para>
    </refsect2>
  </refsect1>
</refentry>
