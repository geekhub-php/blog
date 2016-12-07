<?php

namespace Nima\BlogBundle;

class ModelNima
{
    public $nameCategories;
    public $idPost;
    /**
     * @param string $paramJson
     *
     * @return object
     */
    public function getRevuePosts($nameCategories)
    {
        $resultPostsrevue = array(
            array(
                'title' => 'Rear Window',
                'annotations' => 'Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor safeguards. Sustainability medicine, significant; protect, invest visionary Global South human rights. Improving quality, approach cross-cultural Medecins du Monde emergent reduce child mortality. International Gandhi affordable health care, liberal; developing, Action Against Hunger women and children humanitarian. Enable accelerate, inspire social change, gender equality momentum medical. ',
                'date_post' => '3.12.2016',
            ),
            array(
                'title' => 'Full Metal Jacket',
                'annotations' => 'Respect youth social innovation growth global health. Capacity building recognition; change-makers, local solutions citizens of change. Billionaire philanthropy vulnerable citizens legal aid, evolution, reproductive rights fight against oppression outcomes justice carbon rights. Amplify theory of social change recognize potential deep engagement equal opportunity countries. Development empowerment relief; effect diversification storytelling; time of extraordinary change connect committed. Scalable experience in the field; cooperation involvement human potential immunize.',
                'date_post' => '2.12.2016', ),
            array(
                'title' => 'Respect youth social',
                'annotations' => 'Accelerate progress free-speech change public sector; donation necessities change movements Arab Spring. Making progress dedicated fight against malnutrition vaccines Martin Luther King Jr.. Honesty refugee, resolve socio-economic divide nonviolent resistance gender combat poverty reduce carbon emissions meaningful. Stakeholders complexity clean water celebrate shifting landscape environmental social.',
                'date_post' => '2.12.2016', ),
            array(
                'title' => 'Activist participatory monitoring',
                'annotations' => 'Activist participatory monitoring community social challenges social analysis democracy. Activism social impact, Jane Jacobs institutions global network innovate truth. Dignity measures, planned giving life-saving maintain collaborative consumption, transform the world challenges of our times benefit. Shift catalytic effect carbon emissions reductions public-private partnerships pathway to a better life gender rights process. Jane Addams legitimize nutrition Ford Foundation collaborative cities. Cross-agency coordination citizenry, best practices; facilitate, save the world grantees Nelson Mandela. Readiness working alongside revitalize new approaches solve fluctuation philanthropy progressive. ',
                'date_post' => '2.12.2016', ),
            array(
                'title' => 'Maximize civic engagement foundation',
                'annotations' => 'Effectiveness, civil society promising development emergency response inspire breakthroughs action insurmountable challenges fairness. Political; network investment; poverty humanitarian relief educate catalyze agency beneficiaries. Equality results tackling sustainable rural development integrity partnership UNHCR board of directors. UNICEF world problem solving advocate climate change urban. Breakthrough insights, prevention; sanitation, Cesar Chavez public service sustainable future rural. Elevate, public institutions mobilize, innovation disrupt giving. Tackle, design thinking synthesize, crisis situation progress. Disruption Bono campaign, inclusive organization replicable assistance future accessibility.  ',
                'date_post' => '2.12.2016', ),
            array(
                'title' => 'Mean Streets',
                'annotations' => "Crowdsourcing, fundraising campaign education; The Elders achieve solution informal economies health. Inspiration, Bloomberg Millennium Development Goals, affiliate cornerstone social good. Natural resources combat malaria community health workers human-centered design democratizing the global financial system employment compassion women's rights raise awareness. Meaningful work dialogue economic security medical supplies implementation empower.",
                'date_post' => '1.12.2016', ), );

        return $resultPostsrevue;
    }

    /**
     * @param string $paramJson
     *
     * @return object
     */
    public function getCategories()
    {
        $resultCategories = array(
            array(
                'name' => 'society',
                'countPosts' => '10', ),
            array(
                'name' => 'psychology',
                'countPosts' => '12', ),
            array(
                'name' => 'culture',
                'countPosts' => '5', ),
            array(
                'name' => 'sport',
                'countPosts' => '20', ),
            array(
                'name' => 'politics',
                'countPosts' => '16', ),
            array(
                'name' => 'economics',
                'countPosts' => '7', ),
            array(
                'name' => 'study',
                'countPosts' => '25', ), );

        return $resultCategories;
    }
    /**
     * @param string $paramJson
     *
     * @return object
     */
    public function getSelectedPost($idPost)
    {
        $ResultSelectPost = array(
            'title' => 'Rear Window',
            'annotations' => 'Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor safeguards. Sustainability medicine, significant; protect, invest visionary Global South human rights. Improving quality, approach cross-cultural Medecins du Monde emergent reduce child mortality. International Gandhi affordable health care, liberal; developing, Action Against Hunger women and children humanitarian. Enable accelerate, inspire social change, gender equality momentum medical. ',
            'text_post' => "Peaceful plumpy'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.",
            'date_post' => '3.12.2016', );

        return $ResultSelectPost;
    }
}
