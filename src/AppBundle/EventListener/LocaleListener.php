<?php 
/*
 src/AppBundle/EventListener/LocaleListener.php

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Przemyslaw Zygmunt p.zygmunt@acsoftware.pl [AC SOFTWARE]
 */
class LocaleListener implements EventSubscriberInterface
{

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        
        if (!$request->hasPreviousSession()) {
            return;
        }
                
        if ($locale = $request->attributes->get('_locale')) {
  
            $request->getSession()->set('_locale', $locale);
            
        } else {
            
            $locale = $request->getSession()->get('_locale');
            
            if ( $locale === null ) {
            	
            	$locale = $request->getPreferredLanguage();    	
            	$request->getSession()->set('_locale', $locale);
            }
            
            $request->setLocale($locale);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }
}
?>