<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FixturesBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use PHPCR\Util\NodeHelper;
use Sylius\Bundle\FixturesBundle\DataFixtures\DataFixture;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class LoadPagesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $session = $manager->getPhpcrSession();

        $basepath = $this->container->getParameter('cmf_routing.dynamic.persistence.phpcr.route_basepath');
        NodeHelper::createPath($session, $basepath);

        $routeRoot = $manager->find(null, $basepath);

        $basepath = $this->container->getParameter('cmf_content.persistence.phpcr.content_basepath');
        NodeHelper::createPath($session, $basepath);

        $parent = $manager->find(null, $basepath);
        $repository = $this->container->get('sylius.repository.page');

        // Return Policy
        $route = new Route();
        $route->setPosition($routeRoot, 'return-policy');
        $manager->persist($route);

        $content = $repository->createNew();
        $content->setTitle('Правила возврата');

        $body = <<<BODY
<p>Возврат или замена товаров осуществляется в соответствии с действующим законодательством России &#8212; законом РФ от 7 февраля 1992 г. N 2300-I &#171;О защите прав потребителей&#187;.</p>
<p><a href="#vozvratNadl">Возврат товара надлежащего качества.</a><br />
<a href="#vozvratNenadl">Возврат товара ненадлежащего качества.</a><br />
<a href="#vidachaDeneg">Выдача денег.</a></p>
<p><a id="vozvratNadl" name="vozvratNadl"></a><strong>Статья 25. Право потребителя на обмен товара надлежащего качества</strong></p>
<p>1. Потребитель вправе обменять непродовольственный товар надлежащего качества на аналогичный товар у продавца, у которого этот товар был приобретен, если указанный товар не подошел по форме, габаритам, фасону, расцветке, размеру или комплектации.<br />
(в ред. Федерального от 17.12.1999 N 212-ФЗ)<br />
Потребитель имеет право на обмен непродовольственного товара надлежащего качества в течение четырнадцати дней, не считая дня его покупки.<br />
Обмен непродовольственного товара надлежащего качества проводится, если указанный товар не был в употреблении, сохранены его товарный вид, потребительские свойства, пломбы, фабричные ярлыки, а также имеется товарный чек или кассовый чек либо иной подтверждающий оплату указанного товара документ. Отсутствие у потребителя товарного чека или кассового чека либо иного подтверждающего оплату товара документа не лишает его возможности ссылаться на свидетельские показания.<br />
<a title="Постановление Правительства РФ от 19.01.1998 N 55 (ред. от 27.01.2009) 'Об утверждении Правил продажи отдельных видов товаров, перечня товаров длительного пользования, на которые не распространяется требование покупателя о безвозмездном предоставлении ему" href="http://base.consultant.ru/cons/cgi/online.cgi?req=doc;base=LAW;n=134461;fld=134;dst=4294967295;rnd=0.20232475185977283;from=84302-555" target="_blank">Перечень</a> товаров, не подлежащих обмену по основаниям, указанным в настоящей статье, утверждается Правительством Российской Федерации.</p>
<h6><span style="font-size: 10pt;"><strong>При этом обратите внимание, Закон говорит об обмене товара, а не о возврате денег. Возврат денег возможен только в том случае если аналогичного товара (но подходящего Вам по форме, габаритам, фасону, расцветке, размеру или комплектации) нет в наличии.</strong></span><br />
<span style="font-size: 10pt;"> <strong> Обязательным требованием при возврате товара надлежащего качества является сохранение товарного вида, пломб, фабричных ярлычков.</strong></span></h6>
<h5><span style="font-size: 10pt;"><em><br />
</em><strong>Если у покупателя нет кассового или товарного чека либо иного документа, удостоверяющего покупку, это не является основанием для отказа в удовлетворении его требований. Фактом, удостоверяющим покупку, в данном случае могут являться другие документы, подтверждающие покупку, такие как товарный чек, гарантийный талон и т.д. В случае отсутствия у потребителя указанных документов это не лишает его возможности ссылаться на свидетельские показания в подтверждение факта и условий покупки.</strong></span></h5>
<p>2. В случае, если аналогичный товар отсутствует в продаже на день обращения потребителя к продавцу, потребитель вправе отказаться от исполнения договора купли-продажи и потребовать возврата уплаченной за указанный товар денежной суммы. Требование потребителя о возврате уплаченной за указанный товар денежной суммы подлежит удовлетворению в течение <strong>трех дней</strong> со дня возврата указанного товара.<br />
По соглашению потребителя с продавцом обмен товара может быть предусмотрен при поступлении аналогичного товара в продажу. Продавец обязан незамедлительно сообщить потребителю о поступлении аналогичного товара в продажу.</p>
<p><a id="vozvratNenadl" name="vozvratNenadl"></a><strong>Статья 18. Права потребителя при обнаружении в товаре недостатков</strong></p>
<p>1. Потребитель в случае обнаружения в товаре недостатков, если они не были оговорены продавцом, по своему выбору вправе:<br />
потребовать замены на товар этой же марки (этих же модели и (или) артикула);<br />
потребовать замены на такой же товар другой марки (модели, артикула) с соответствующим перерасчетом покупной цены;<br />
потребовать соразмерного уменьшения покупной цены;<br />
потребовать незамедлительного безвозмездного устранения недостатков товара или возмещения расходов на их исправление потребителем или третьим лицом;<br />
отказаться от исполнения договора купли-продажи и потребовать возврата уплаченной за товар суммы. По требованию продавца и за его счет потребитель должен возвратить товар с недостатками.<br />
При этом потребитель вправе потребовать также полного возмещения убытков, причиненных ему вследствие продажи товара ненадлежащего качества. Убытки возмещаются в сроки, установленные настоящим <a title="Текущий документ" href="http://www.consultant.ru/popular/consumerism/37_2.html#p427" target="_blank">Законом</a> для удовлетворения соответствующих требований потребителя.<br />
В отношении <a title="Постановление Правительства РФ от 10.11.2011 N 924 'Об утверждении Перечня технически сложных товаров, в отношении которых требования потребителя об их замене подлежат удовлетворению в случае обнаружения в товарах существенных недостатков'" href="http://base.consultant.ru/cons/cgi/online.cgi?req=doc;base=LAW;n=121597;fld=134;dst=100009" target="_blank">технически сложного товара</a> потребитель в случае обнаружения в нем недостатков вправе отказаться от исполнения договора купли-продажи и потребовать возврата уплаченной за такой товар суммы либо предъявить требование о его замене на товар этой же марки (модели, артикула) или на такой же товар другой марки (модели, артикула) с соответствующим перерасчетом покупной цены в течение пятнадцати дней со дня передачи потребителю такого товара. По истечении этого срока указанные требования подлежат удовлетворению в одном из следующих случаев:<br />
обнаружение <a href="http://base.consultant.ru/cons/cgi/online.cgi?req=doc;base=LAW;n=148878;div=LAW;dst=100331;rnd=0.6305609706823712" target="_blank">существенного недостатка товара</a>;<br />
нарушение установленных настоящим <a title="Текущий документ" href="http://www.consultant.ru/popular/consumerism/37_2.html#p402" target="_blank">Законом</a> сроков устранения недостатков товара;<br />
невозможность использования товара в течение каждого года гарантийного срока в совокупности более чем тридцать дней вследствие неоднократного устранения его различных недостатков.<br />
<a title="Постановление Правительства РФ от 13.05.1997 N 575 'Об утверждении Перечня технически сложных товаров, в отношении которых требования потребителя об их замене подлежат удовлетворению в случае обнаружения в товарах существенных недостатков'" href="http://base.consultant.ru/cons/cgi/online.cgi?req=doc;base=LAW;n=121597;fld=134;dst=100009;rnd=0.7250695316952518" target="_blank">Перечень</a> технически сложных товаров утверждается Правительством Российской Федерации.</p>
<p><a id="vidachaDeneg" name="vidachaDeneg"></a><strong>Выдача денег. </strong></p>
<p>В соответствии с Типовыми правилами эксплуатации контрольно-кассовых машин при осуществлении денежных расчетов с населением, утвержденными письмом Минфина России от 30.08.93 N 104 и постановлением Госкомстата России от 25.12.98 N 132 &#171;Об утверждении унифицированных форм первичной учетной документации по учету денежных расчетов с населением при осуществлении торговых операций с применением контрольно-кассовых машин&#187;,<br />
применяется следующий <strong>порядок оформления возврата товара в день покупки</strong> (до закрытия смены и снятия Z-отчета) как надлежащего, так и ненадлежащего качества.<br />
Возврат денежной суммы производится из операционной кассы организации по чеку, выданному в данной кассе, и только при наличии на чеке подписи директора (заведующего) или его заместителя.<br />
На сумму возврата оформляется акт о возврате товара по форме N КМ-3. Акт составляют члены комиссии в одном экземпляре.<br />
Погашенные (первоначальные) чеки наклеиваются на лист бумаги и вместе с актом сдаются в бухгалтерию, где они должны храниться при текстовых документах за данное число.<br />
Суммы, выплаченные по возвращенным покупателям и неиспользованным кассовым чекам, записываются в графу 16 книги кассира-операциониста, и на итоговую сумму уменьшается сумма выручки за этот день.<br />
В случае предъявления покупателем кассового чека, содержащего несколько наименований товара, организация может выдать ему взамен копию чека, заверенную администрацией организации.<br />
Прием от покупателя возвращенного товара оформляется накладной, которая составляется в двух экземплярах, один из которых прикладывается к товарному отчету, другой вручается покупателю и является основанием для получения денежной суммы за возвращенный товар.</p>
<p><strong>Порядок оформления возврата товара покупателем не в день покупки</strong> (по истечении рабочего дня после закрытия продавцом смены и снятия Z-отчета) определен письмом ЦБ РФ от 04.10.93 N 18 &#171;Об утверждении порядка ведения кассовых операций в Российской Федерации&#187; и Методическими рекомендациями по учету оформления операций приема, хранения и отпуска товаров в организациях торговли, утвержденными письмом Комитета РФ по торговле от 10.07.96 N 1-794/32-5.<br />
Возврат денег осуществляется только из главной кассы организации на основании письменного заявления покупателя с указанием фамилии, имени, отчества и только при предъявлении документа, удостоверяющего личность (паспорта или документа, его заменяющего).<br />
Для возврата денег покупателю из главной кассы организация составляет расходно-кассовый ордер по форме N КО-2, порядок оформления которой утвержден постановлением Госкомстата России от 18.08.98 N 88 &#171;Об утверждении унифицированных форм первичной учетной документации по учету кассовых операций, по учету результатов инвентаризации&#187;.<br />
В этом случае прием от покупателя возвращенного товара также оформляется накладной в порядке, изложенном выше.<br />
Учтите, что на основании перечисленных документов организация должна производить соответствующие бухгалтерские записи в регистрах бухгалтерского учета.</p>
<h6><span style="font-size: 10pt;"><strong>Часто люди не понимают правомерность требования предъявления документа удостоверяющего личность. Возвращая деньги, магазин проводит операцию возврата через расходный кассовый ордер. Там обязательно указываются паспортные данные получателя денег. Эта форма утверждена и проверяется налоговой.</strong></span><br />
<span style="font-size: 10pt;"> <strong> Смотрите Налоговый кодекс РФ.</strong></span><br />
<span style="font-size: 10pt;"> <strong> Если деньги (по Вашему мнению) возвращать просто так, то налоговая и соответственно государство будет в пролёте. Я скажу, что продал на 1000000 и денег вернул на 1000000 (кому-то) налоги платить не с чего. А расходник могут отследить.</strong></span><br />
<span style="font-size: 10pt;"> <strong> Документом в РФ, удостоверяющим личность, является: паспорт, з/паспорт, справка об освобождении, военный билет, уд. личности офицера.</strong></span></h6>
<p>Если у Вас есть замечания по данной статье или если обнаружите неточности, напишите пожалуйста об этом в этой форме.</p>
BODY;

        $content->setBody($body);
        $content->addRoute($route);
        $content->setParent($parent);
        $content->setName('return-policy');

        $manager->persist($content);

        // Discounts
        $route = new Route();
        $route->setPosition($routeRoot, 'discounts');
        $manager->persist($route);

        $content = $repository->createNew();
        $content->setTitle('Наши скидки');
        $content->setBody($this->faker->text(500));
        $content->addRoute($route);
        $content->setParent($parent);
        $content->setName('discounts');

        $manager->persist($content);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
