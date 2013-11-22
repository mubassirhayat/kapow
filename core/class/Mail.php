<?php

class KPMail
{
    private $instance = null;

    public static function init( $options = array() )
    {
        return new self( $options );
    }

    private $from              = null;
    private $subject           = '';
    private $to                = null;
    private $cc                = null;
    private $bcc               = null;
    private $errors            = true;
    private $encodeSubject     = false;
    private $mailContent       = '';
    private $mailData          = array();
    private $mailDataLabels    = array();
    private $helpMessage       = '';
    private $mailFooterMessage = '';
    private $charset           = 'utf-8';
    private $textColor         = '#333333';
    private $backgroundColor   = '#ffffff';
    
    public function __construct( $options = array() )
    {
        if( false !== array_key_exists( 'from', $options ) )
        {
            $this->from = $options['from'];
        }

        if( false !== array_key_exists( 'subject', $options ) )
        {
            $this->from = $options['subject'];
        }

        if( false !== array_key_exists( 'to', $options ) )
        {
            $this->from = $options['to'];
        }

        if( false !== array_key_exists( 'cc', $options ) )
        {
            $this->from = $options['cc'];
        }

        if( false !== array_key_exists( 'bcc', $options ) )
        {
            $this->from = $options['bcc'];
        }

        if( false !== array_key_exists( 'body-style', $options ) )
        {
            $this->bodyStyle = $options['body-style'];
        }
    }

    public function setFrom( $from )
    {
        $this->from = $from;
        
        return $this;
    }

    public function setTo( $to )
    {
        $this->to = $to;
        
        return $this;
    }

    public function setCc( $cc )
    {
        $this->cc = $cc;
        
        return $this;
    }

    public function setBcc( $bcc )
    {
        $this->bcc = $bcc;
        
        return $this;
    }

    public function setBackgroundColor( $color )
    {
        $this->backgroundColor = $color;
        
        return $this;
    }

    public function setTextColor( $color )
    {
        $this->textColor = $color;
        
        return $this;
    }

    public function setSubject( $subject )
    {
        $this->subject = $subject;
        
        return $this;
    }

    public function setBodyStyle( $style )
    {
        $this->bodyStyle = $style;
        
        return $this;
    }

    public function setMailContent( $content )
    {
        $this->mailContent = $content;
        
        return $this;
    }

    public function setMailData( $data )
    {
        $this->mailData = $data;
        
        return $this;
    }

    public function setMailDataLabels( $labels )
    {
        $this->mailDataLabels = $labels;
        
        return $this;
    }

    public function setHelpMessage( $message )
    {
        $this->helpMessage = $message;
        
        return $this;
    }

    public function setMailFooterMessage( $message )
    {
        $this->mailFooterMessage = $message;
        
        return $this;
    }

    private function _getHeader()
    {
        $header  = 'Return-path: '. $this->from . "\n";
        $header .= 'Reply-to: '. $this->from . "\n";
        $header .= 'Content-Type: text/html; charset=' . $this->charset . "\n";
        $header .= 'Content-Transfer-Encoding: 7bit' . "\n";
        $header .= 'From: ' . $this->from . "\n";
        
        if( null !== $this->cc )
        {
            $header .= 'Cc: ' . $this->cc . "\n";
        }

        if( null !== $this->bcc )
        {
            $header .= 'BCC: ' . $this->bcc . "\n";
        }
        
        $header .= 'X-Priority: 3' . "\n";
        $header .= 'X-Mailer: PHP v ' . phpversion() . "\n";
        $header .= 'MIME-Version: 1.0' . "\n";
        $header .= 'Date: ' . date('r') . "\n";
        $header .= "\n\n";
        
        return $header;
    }
    
    private function _getSubject()
    {
        $subject = $this->subject;
        
        if( true === $this->encodeSubject )
        {
            $subject = '=?' . $this->charset . '?B?' . base64_encode( $subject ) . '?=';
        }

        return $subject;
    }
    
    private function _getContent()
    {
        $content = '';
        ob_start();
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title><?php the_title(); ?></title>
            <style type="text/css">
                #outlook a {padding:0;} 
                body{width:100% !important; color: <?php print $this->textColor; ?>; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family: Arial; background: <?php print $this->backgroundColor; ?>}
                .ExternalClass {width:100%;}
                .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
                #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important; background: <?php print $this->backgroundColor; ?>;}
                table td {border-collapse: collapse;}
            </style>
        </head>
        <body>
            <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
                <tr>
                    <td>
                        <?php if( '' == $this->mailContent && !empty( $this->mailData ) ): ?>
                            <table cellpadding="0" cellspacing="0" border="0" width="700" align="center" style="">
                                <tr>
                                    <td>
                                        <h3 style="font-size: 18px; color: #666666; margin-bottom: 0;"><?php print $this->subject; ?></h3>
                                    </td>
                                </tr>
                                
                                <?php if( '' != $this->helpMessage ): ?>
                                    <tr>
                                        <td style="border-bottom: 1px solid #ccc;">
                                            <p style="font-size: 13px;"><?php print $this->helpMessage; ?></p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <?php
                                $rows = count( $this->mailData );
                                $i    = 1;
                                ?>
                                <?php if( $rows ): foreach( $this->mailData as $key => $value ): ?>
                                    <tr>
                                        <td style="<?php print $i++ < $rows ? 'border-bottom: 1px dotted #ccc;' : ''; ?>">
                                            <?php if( is_array( $this->mailDataLabels ) && array_key_exists( $key, $this->mailDataLabels ) ): ?>
                                                <h5 style="font-size: 15px; color: #555555; margin-bottom: 6px; margin-top: 10px;"><?php print $this->mailDataLabels[ $key ] ?>:</h5>
                                            <?php else: ?>
                                                &nbsp;
                                            <?php endif; ?>
                                            <p style="font-size: 15px; color: #444; margin-top: 4px; margin-bottom: 15px; padding-left: 10px;"><?php print $value; ?></p>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>


                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <?php if( '' != $this->mailFooterMessage ): ?>
                                    <tr>
                                        <td style="border-top: 1px solid #ccc;">
                                            <p style="font-size: 12px;"><?php print $this->mailFooterMessage; ?></p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        <?php else: ?>
                            <?php print $this->mailContent; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        $content = ob_get_contents();
        ob_clean();
        
        return $content;
    }
    
    public function send()
    {
        return mail( $this->to, $this->_getSubject(), $this->_getContent(), $this->_getHeader() );
    }
}