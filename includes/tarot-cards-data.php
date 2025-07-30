<?php
/**
 * Tarot Cards Data
 * Complete list of all 78 tarot cards with their meanings
 */

if (!defined('ABSPATH')) {
    exit;
}

class Tarot_Cards_Data {
    
    /**
     * Get all 78 tarot cards data
     */
    public static function get_all_cards() {
        return array(
            // Major Arcana (22 cards)
            array(
                'card_name' => 'The Fool',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Fool represents new beginnings, innocence, spontaneity, and a free spirit. This card suggests taking a leap of faith and embracing new opportunities with an open heart.',
                'card_content_reversed' => 'The Fool reversed suggests recklessness, risk-taking without consideration, and being naive or foolish. It warns against acting without thinking or making impulsive decisions.',
                'card_position' => 1
            ),
            array(
                'card_name' => 'The Magician',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Magician represents manifestation, resourcefulness, power, and inspired action. This card indicates that you have all the tools and resources needed to achieve your goals.',
                'card_content_reversed' => 'The Magician reversed suggests manipulation, poor planning, untapped talents, and lack of focus. It indicates missed opportunities or not using your abilities effectively.',
                'card_position' => 2
            ),
            array(
                'card_name' => 'The High Priestess',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The High Priestess represents intuition, sacred knowledge, divine feminine, and the subconscious mind. This card suggests listening to your inner voice and trusting your instincts.',
                'card_content_reversed' => 'The High Priestess reversed suggests secrets, disconnected from intuition, withdrawal, and silence. It indicates not listening to your inner voice or ignoring your instincts.',
                'card_position' => 3
            ),
            array(
                'card_name' => 'The Empress',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Empress represents femininity, beauty, nature, abundance, and nurturing. This card indicates growth, creativity, and the manifestation of your desires.',
                'card_content_reversed' => 'The Empress reversed suggests creative block, dependence on others, emptiness, and lack of growth. It indicates feeling uninspired or disconnected from your creative energy.',
                'card_position' => 4
            ),
            array(
                'card_name' => 'The Emperor',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Emperor represents authority, structure, control, and fatherhood. This card suggests taking charge of your situation and establishing order in your life.',
                'card_content_reversed' => 'The Emperor reversed suggests excessive control, rigidity, lack of discipline, and immaturity. It indicates being too controlling or not taking responsibility for your actions.',
                'card_position' => 5
            ),
            array(
                'card_name' => 'The Hierophant',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Hierophant represents tradition, conformity, morality, and ethics. This card suggests following established systems and seeking guidance from mentors or spiritual leaders.',
                'card_content_reversed' => 'The Hierophant reversed suggests challenging beliefs, personal morality, freedom, and challenging the status quo. It indicates questioning traditional values or breaking free from conventions.',
                'card_position' => 6
            ),
            array(
                'card_name' => 'The Lovers',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Lovers represent love, harmony, relationships, values alignment, and choices. This card indicates important decisions about love, partnerships, and personal values.',
                'card_content_reversed' => 'The Lovers reversed suggests disharmony, imbalance, misalignment of values, and discord. It indicates relationship problems or making choices that don\'t align with your true values.',
                'card_position' => 7
            ),
            array(
                'card_name' => 'The Chariot',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Chariot represents control, willpower, victory, assertion, and determination. This card suggests overcoming obstacles through discipline and focused action.',
                'card_content_reversed' => 'The Chariot reversed suggests lack of control, lack of direction, aggression, and no self-discipline. It indicates feeling out of control or lacking the willpower to achieve your goals.',
                'card_position' => 8
            ),
            array(
                'card_name' => 'Strength',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'Strength represents courage, persuasion, influence, compassion, and inner strength. This card suggests having the courage to face challenges and the compassion to help others.',
                'card_content_reversed' => 'Strength reversed suggests inner strength, self-doubt, low energy, and raw emotion. It indicates feeling weak or lacking confidence in your abilities.',
                'card_position' => 9
            ),
            array(
                'card_name' => 'The Hermit',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Hermit represents soul-searching, introspection, being alone, inner guidance, and solitude. This card suggests taking time for self-reflection and seeking inner wisdom.',
                'card_content_reversed' => 'The Hermit reversed suggests isolation, loneliness, withdrawal, and rejection. It indicates feeling disconnected from others or avoiding social interaction.',
                'card_position' => 10
            ),
            array(
                'card_name' => 'Wheel of Fortune',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Wheel of Fortune represents good luck, karma, life cycles, destiny, and a turning point. This card suggests that change is coming and you should embrace it.',
                'card_content_reversed' => 'The Wheel of Fortune reversed suggests bad luck, resistance to change, breaking cycles, and lack of control. It indicates feeling stuck or resisting necessary changes.',
                'card_position' => 11
            ),
            array(
                'card_name' => 'Justice',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'Justice represents justice, fairness, truth, cause and effect, and law. This card suggests making fair and balanced decisions and taking responsibility for your actions.',
                'card_content_reversed' => 'Justice reversed suggests unfairness, lack of accountability, dishonesty, and unclosed cycles. It indicates feeling treated unfairly or avoiding responsibility.',
                'card_position' => 12
            ),
            array(
                'card_name' => 'The Hanged Man',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Hanged Man represents surrender, letting go, new perspectives, enlightenment, and sacrifice. This card suggests seeing things from a different angle and letting go of control.',
                'card_content_reversed' => 'The Hanged Man reversed suggests stalling, needless sacrifice, fear of sacrifice, and fear of change. It indicates resisting necessary changes or being stuck in old patterns.',
                'card_position' => 13
            ),
            array(
                'card_name' => 'Death',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'Death represents endings, change, transformation, transition, and metamorphosis. This card suggests that something is ending to make way for something new.',
                'card_content_reversed' => 'Death reversed suggests resistance to change, inability to move on, stagnation, and decay. It indicates holding onto the past or refusing to accept necessary endings.',
                'card_position' => 14
            ),
            array(
                'card_name' => 'Temperance',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'Temperance represents balance, moderation, patience, purpose, and meaning. This card suggests finding balance in your life and practicing patience.',
                'card_content_reversed' => 'Temperance reversed suggests imbalance, excess, lack of harmony, and hastiness. It indicates going to extremes or acting without patience.',
                'card_position' => 15
            ),
            array(
                'card_name' => 'The Devil',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Devil represents shadow self, attachment, addiction, restriction, and sexuality. This card suggests examining your attachments and facing your shadow side.',
                'card_content_reversed' => 'The Devil reversed suggests breaking free, release, restoring control, and power reclaimed. It indicates breaking free from negative patterns or addictions.',
                'card_position' => 16
            ),
            array(
                'card_name' => 'The Tower',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Tower represents sudden change, upheaval, chaos, revelation, and awakening. This card suggests that a sudden change will bring clarity and new understanding.',
                'card_content_reversed' => 'The Tower reversed suggests fear of change, avoiding disaster, delaying the inevitable, and internal explosion. It indicates resisting necessary changes or internal turmoil.',
                'card_position' => 17
            ),
            array(
                'card_name' => 'The Star',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Star represents hope, faith, purpose, renewal, and spirituality. This card suggests having faith in the future and finding your purpose.',
                'card_content_reversed' => 'The Star reversed suggests lack of faith, despair, self-trust, disconnection, and lack of inspiration. It indicates losing hope or feeling disconnected from your purpose.',
                'card_position' => 18
            ),
            array(
                'card_name' => 'The Moon',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Moon represents illusion, fear, anxiety, subconscious, and intuition. This card suggests trusting your intuition and facing your fears.',
                'card_content_reversed' => 'The Moon reversed suggests release of fear, repressed emotion, inner confusion, and confusion. It indicates releasing fears or feeling confused about your emotions.',
                'card_position' => 19
            ),
            array(
                'card_name' => 'The Sun',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Sun represents joy, success, celebration, positivity, and vitality. This card suggests embracing joy and celebrating your successes.',
                'card_content_reversed' => 'The Sun reversed suggests inner child, feeling down, overly optimistic, and unrealistic expectations. It indicates feeling down or being overly optimistic.',
                'card_position' => 20
            ),
            array(
                'card_name' => 'Judgement',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'Judgement represents judgement, rebirth, inner calling, absolution, and awakening. This card suggests heeding your inner calling and experiencing spiritual awakening.',
                'card_content_reversed' => 'Judgement reversed suggests self-doubt, inner critic, ignoring the call, and self-judgement. It indicates doubting yourself or ignoring your inner calling.',
                'card_position' => 21
            ),
            array(
                'card_name' => 'The World',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The World represents completion, integration, accomplishment, travel, and unity. This card suggests completing a cycle and achieving wholeness.',
                'card_content_reversed' => 'The World reversed suggests seeking personal closure, short-cut to success, and delay. It indicates seeking closure or taking shortcuts.',
                'card_position' => 22
            ),
            
            // Minor Arcana - Wands (14 cards)
            array(
                'card_name' => 'Ace of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ace of Wands represents creation, willpower, inspiration, desire, and new opportunities. This card suggests new creative projects and inspired action.',
                'card_content_reversed' => 'The Ace of Wands reversed suggests lack of energy, lack of passion, delays, and missed opportunities. It indicates feeling uninspired or missing opportunities.',
                'card_position' => 23
            ),
            array(
                'card_name' => 'Two of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Two of Wands represents future planning, making decisions, leaving comfort zone, and discovery. This card suggests planning for the future and making important decisions.',
                'card_content_reversed' => 'The Two of Wands reversed suggests fear of unknown, playing safe, bad planning, and overanalysis. It indicates fearing the unknown or overthinking decisions.',
                'card_position' => 24
            ),
            array(
                'card_name' => 'Three of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Three of Wands represents expansion, foresight, overseas opportunities, and adventure. This card suggests expanding your horizons and exploring new opportunities.',
                'card_content_reversed' => 'The Three of Wands reversed suggests delays, frustration, lack of direction, and obstacles. It indicates experiencing delays or feeling directionless.',
                'card_position' => 25
            ),
            array(
                'card_name' => 'Four of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Four of Wands represents celebration, joy, harmony, relaxation, and homecoming. This card suggests celebrating achievements and finding harmony.',
                'card_content_reversed' => 'The Four of Wands reversed suggests personal celebration, inner conflict, conflict with others, and disharmony. It indicates inner conflict or disharmony with others.',
                'card_position' => 26
            ),
            array(
                'card_name' => 'Five of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Five of Wands represents conflict, disagreements, competition, tension, and diversity. This card suggests facing challenges and healthy competition.',
                'card_content_reversed' => 'The Five of Wands reversed suggests avoiding conflict, respecting differences, and tension release. It indicates avoiding conflict or releasing tension.',
                'card_position' => 27
            ),
            array(
                'card_name' => 'Six of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Six of Wands represents success, public recognition, progress, self-confidence, and victory. This card suggests celebrating success and gaining recognition.',
                'card_content_reversed' => 'The Six of Wands reversed suggests private achievement, fall from grace, egotism, and lack of confidence. It indicates private achievements or losing confidence.',
                'card_position' => 28
            ),
            array(
                'card_name' => 'Seven of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Seven of Wands represents perseverance, defensive position, maintaining control, and standing up for yourself. This card suggests defending your position and persevering.',
                'card_content_reversed' => 'The Seven of Wands reversed suggests giving up, overwhelmed, defensive, and paranoia. It indicates giving up or feeling overwhelmed.',
                'card_position' => 29
            ),
            array(
                'card_name' => 'Eight of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Eight of Wands represents movement, fast paced change, action, alignment, and air travel. This card suggests rapid change and taking action.',
                'card_content_reversed' => 'The Eight of Wands reversed suggests delays, frustration, lack of direction, and slowing down. It indicates experiencing delays or feeling directionless.',
                'card_position' => 30
            ),
            array(
                'card_name' => 'Nine of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Nine of Wands represents resilience, courage, persistence, test of faith, and inner strength. This card suggests showing resilience and inner strength.',
                'card_content_reversed' => 'The Nine of Wands reversed suggests inner resources, struggle, overwhelm, and defensive. It indicates inner resources or feeling overwhelmed.',
                'card_position' => 31
            ),
            array(
                'card_name' => 'Ten of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ten of Wands represents burden, extra responsibility, hard work, completion, and obligation. This card suggests carrying heavy burdens and responsibilities.',
                'card_content_reversed' => 'The Ten of Wands reversed suggests delegation, over-commitment, and in-burden. It indicates delegating tasks or over-committing.',
                'card_position' => 32
            ),
            array(
                'card_name' => 'Page of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Page of Wands represents exploration, excitement, freedom, adventure, and new opportunities. This card suggests exploring new possibilities with excitement.',
                'card_content_reversed' => 'The Page of Wands reversed suggests lack of direction, procrastination, creating conflict, and all talk and no action. It indicates lacking direction or procrastinating.',
                'card_position' => 33
            ),
            array(
                'card_name' => 'Knight of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Knight of Wands represents energy, passion, lust, action, adventure, and impulsiveness. This card suggests taking action with passion and energy.',
                'card_content_reversed' => 'The Knight of Wands reversed suggests anger, impulsiveness, recklessness, and lack of direction. It indicates acting impulsively or lacking direction.',
                'card_position' => 34
            ),
            array(
                'card_name' => 'Queen of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Queen of Wands represents courage, determination, independence, vivacity, and warmth. This card suggests showing courage and independence.',
                'card_content_reversed' => 'The Queen of Wands reversed suggests selfishness, jealousy, insecurities, and dependence. It indicates being selfish or feeling insecure.',
                'card_position' => 35
            ),
            array(
                'card_name' => 'King of Wands',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The King of Wands represents natural-born leader, vision, entrepreneur, honour, and respect. This card suggests leading with vision and honour.',
                'card_content_reversed' => 'The King of Wands reversed suggests impulsiveness, overbearing, unachievable expectations, and quick to anger. It indicates being impulsive or overbearing.',
                'card_position' => 36
            ),
            
            // Minor Arcana - Cups (14 cards)
            array(
                'card_name' => 'Ace of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ace of Cups represents new feelings, spirituality, intuition, and love. This card suggests new emotional beginnings and spiritual awakening.',
                'card_content_reversed' => 'The Ace of Cups reversed suggests emotional loss, blocked creativity, emptiness, and lack of inspiration. It indicates emotional loss or blocked creativity.',
                'card_position' => 37
            ),
            array(
                'card_name' => 'Two of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Two of Cups represents unity, partnership, connection, attraction, and relationships. This card suggests forming connections and partnerships.',
                'card_content_reversed' => 'The Two of Cups reversed suggests broken relationships, disharmony, distrust, and lack of connection. It indicates broken relationships or disharmony.',
                'card_position' => 38
            ),
            array(
                'card_name' => 'Three of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Three of Cups represents friendship, creativity, collaborations, and joy. This card suggests celebrating with friends and creative collaborations.',
                'card_content_reversed' => 'The Three of Cups reversed suggests overindulgence, gossip, isolation, solitude, and miscommunication. It indicates overindulging or feeling isolated.',
                'card_position' => 39
            ),
            array(
                'card_name' => 'Four of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Four of Cups represents contemplation, apathy, reevaluation, and disconnectedness. This card suggests taking time for contemplation and reevaluation.',
                'card_content_reversed' => 'The Four of Cups reversed suggests new opportunities, same old problem, and awareness. It indicates new opportunities or awareness of old problems.',
                'card_position' => 40
            ),
            array(
                'card_name' => 'Five of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Five of Cups represents loss, grief, self-pity, and disappointment. This card suggests experiencing loss and processing grief.',
                'card_content_reversed' => 'The Five of Cups reversed suggests acceptance, moving on, finding peace, and personal setbacks. It indicates accepting loss and moving on.',
                'card_position' => 41
            ),
            array(
                'card_name' => 'Six of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Six of Cups represents reunions, nostalgia, memories, innocence, and joy. This card suggests reconnecting with the past and finding joy.',
                'card_content_reversed' => 'The Six of Cups reversed suggests living in the past, forgiveness, lacking playfulness, and moving forward. It indicates living in the past or moving forward.',
                'card_position' => 42
            ),
            array(
                'card_name' => 'Seven of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Seven of Cups represents choices, fantasy, illusion, wishful thinking, and imagination. This card suggests making choices and using imagination.',
                'card_content_reversed' => 'The Seven of Cups reversed suggests clarity, making choices, disillusionment, and lack of options. It indicates gaining clarity or feeling disillusioned.',
                'card_position' => 43
            ),
            array(
                'card_name' => 'Eight of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Eight of Cups represents walking away, disillusionment, leaving behind, and withdrawal. This card suggests walking away from what no longer serves you.',
                'card_content_reversed' => 'The Eight of Cups reversed suggests avoidance, fear of change, fear of loss, and trying one more time. It indicates avoiding change or trying one more time.',
                'card_position' => 44
            ),
            array(
                'card_name' => 'Nine of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Nine of Cups represents satisfaction, emotional stability, luxury, and self-sufficiency. This card suggests finding satisfaction and emotional stability.',
                'card_content_reversed' => 'The Nine of Cups reversed suggests inner happiness, materialism, dissatisfaction, and self-pity. It indicates inner happiness or feeling dissatisfied.',
                'card_position' => 45
            ),
            array(
                'card_name' => 'Ten of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ten of Cups represents divine love, blissful relationships, harmony, and alignment. This card suggests experiencing divine love and harmonious relationships.',
                'card_content_reversed' => 'The Ten of Cups reversed suggests disconnection, misaligned values, struggling relationships, and disharmony. It indicates disconnection or disharmony in relationships.',
                'card_position' => 46
            ),
            array(
                'card_name' => 'Page of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Page of Cups represents creative opportunities, intuitive messages, curiosity, and possibility. This card suggests creative opportunities and intuitive messages.',
                'card_content_reversed' => 'The Page of Cups reversed suggests new ideas, doubting intuition, creative blocks, and emotional manipulation. It indicates new ideas or doubting intuition.',
                'card_position' => 47
            ),
            array(
                'card_name' => 'Knight of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Knight of Cups represents creativity, romance, charm, imagination, and beauty. This card suggests creative expression and romantic connections.',
                'card_content_reversed' => 'The Knight of Cups reversed suggests self-expression, all talk and no action, and unrealistic expectations. It indicates self-expression or unrealistic expectations.',
                'card_position' => 48
            ),
            array(
                'card_name' => 'Queen of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Queen of Cups represents compassion, calm, comfort, emotional security, and intuition. This card suggests showing compassion and emotional security.',
                'card_content_reversed' => 'The Queen of Cups reversed suggests inner feelings, self-care, self-compassion, and self-protection. It indicates inner feelings or self-care.',
                'card_position' => 49
            ),
            array(
                'card_name' => 'King of Cups',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The King of Cups represents emotional balance, generosity, diplomacy, and inner feelings. This card suggests emotional balance and generosity.',
                'card_content_reversed' => 'The King of Cups reversed suggests coldness, moodiness, bad advice, and manipulation. It indicates coldness or manipulation.',
                'card_position' => 50
            ),
            
            // Minor Arcana - Swords (14 cards)
            array(
                'card_name' => 'Ace of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ace of Swords represents breakthrough, clarity, sharp mind, and new ideas. This card suggests mental breakthroughs and new ideas.',
                'card_content_reversed' => 'The Ace of Swords reversed suggests confusion, brutality, chaos, and lack of clarity. It indicates confusion or lack of clarity.',
                'card_position' => 51
            ),
            array(
                'card_name' => 'Two of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Two of Swords represents difficult choices, indecision, stalemate, and blocked emotions. This card suggests making difficult choices and decisions.',
                'card_content_reversed' => 'The Two of Swords reversed suggests no right choice, confusion, and release of tension. It indicates confusion or releasing tension.',
                'card_position' => 52
            ),
            array(
                'card_name' => 'Three of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Three of Swords represents heartbreak, suffering, grief, and emotional pain. This card suggests experiencing heartbreak and emotional pain.',
                'card_content_reversed' => 'The Three of Swords reversed suggests negative self-talk, releasing pain, optimism, and forgiveness. It indicates negative self-talk or releasing pain.',
                'card_position' => 53
            ),
            array(
                'card_name' => 'Four of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Four of Swords represents rest, relaxation, meditation, contemplation, and recuperation. This card suggests taking time to rest and recuperate.',
                'card_content_reversed' => 'The Four of Swords reversed suggests exhaustion, burn-out, deep contemplation, and stagnation. It indicates exhaustion or deep contemplation.',
                'card_position' => 54
            ),
            array(
                'card_name' => 'Five of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Five of Swords represents conflict, disagreements, competition, defeat, and win at all costs. This card suggests facing conflict and competition.',
                'card_content_reversed' => 'The Five of Swords reversed suggests reconciliation, making up, past resentment, and forgiveness. It indicates reconciliation or forgiveness.',
                'card_position' => 55
            ),
            array(
                'card_name' => 'Six of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Six of Swords represents transition, leaving behind, moving forward, and personal journey. This card suggests transitioning and moving forward.',
                'card_content_reversed' => 'The Six of Swords reversed suggests emotional baggage, unresolved issues, resisting transition, and unfinished business. It indicates emotional baggage or resisting transition.',
                'card_position' => 56
            ),
            array(
                'card_name' => 'Seven of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Seven of Swords represents deception, trickery, tactics, and betrayal. This card suggests being aware of deception and betrayal.',
                'card_content_reversed' => 'The Seven of Swords reversed suggests coming clean, rethinking approach, deception, and betrayal. It indicates coming clean or rethinking approach.',
                'card_position' => 57
            ),
            array(
                'card_name' => 'Eight of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Eight of Swords represents negative thoughts, self-imposed restriction, imprisonment, and entrapment. This card suggests breaking free from negative thoughts.',
                'card_content_reversed' => 'The Eight of Swords reversed suggests self-acceptance, new perspective, open to change, and paranoia. It indicates self-acceptance or new perspective.',
                'card_position' => 58
            ),
            array(
                'card_name' => 'Nine of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Nine of Swords represents anxiety, worry, fear, depression, and nightmares. This card suggests dealing with anxiety and worry.',
                'card_content_reversed' => 'The Nine of Swords reversed suggests inner turmoil, deep-seated fears, secrets, and releasing worry. It indicates inner turmoil or releasing worry.',
                'card_position' => 59
            ),
            array(
                'card_name' => 'Ten of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ten of Swords represents pain, defeat, loss, and rock bottom. This card suggests experiencing pain and hitting rock bottom.',
                'card_content_reversed' => 'The Ten of Swords reversed suggests recovery, regeneration, resisting an inevitable end, and survival. It indicates recovery or survival.',
                'card_position' => 60
            ),
            array(
                'card_name' => 'Page of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Page of Swords represents new ideas, curiosity, thirst for knowledge, and new ways of communicating. This card suggests new ideas and curiosity.',
                'card_content_reversed' => 'The Page of Swords reversed suggests self-expression, all talk and no action, haphazard action, and not thinking things through. It indicates self-expression or not thinking things through.',
                'card_position' => 61
            ),
            array(
                'card_name' => 'Knight of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Knight of Swords represents action, impulsiveness, defending beliefs, and swift change. This card suggests taking action and defending beliefs.',
                'card_content_reversed' => 'The Knight of Swords reversed suggests no direction, disregard for consequences, unprepared, and all talk and no action. It indicates no direction or disregard for consequences.',
                'card_position' => 62
            ),
            array(
                'card_name' => 'Queen of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Queen of Swords represents independent, unbiased judgement, clear boundaries, and direct communication. This card suggests independent judgement and clear boundaries.',
                'card_content_reversed' => 'The Queen of Swords reversed suggests coldness, bitterness, harsh truth, and isolation. It indicates coldness or harsh truth.',
                'card_position' => 63
            ),
            array(
                'card_name' => 'King of Swords',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The King of Swords represents mental clarity, intellectual power, authority, and truth. This card suggests mental clarity and intellectual power.',
                'card_content_reversed' => 'The King of Swords reversed suggests quiet power, inner truth, misuse of power, and manipulation. It indicates quiet power or misuse of power.',
                'card_position' => 64
            ),
            
            // Minor Arcana - Pentacles (14 cards)
            array(
                'card_name' => 'Ace of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ace of Pentacles represents new financial ideas, manifestation, abundance, and opportunity. This card suggests new financial opportunities and manifestation.',
                'card_content_reversed' => 'The Ace of Pentacles reversed suggests lost opportunity, scarcity mindset, and lack of planning. It indicates lost opportunity or scarcity mindset.',
                'card_position' => 65
            ),
            array(
                'card_name' => 'Two of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Two of Pentacles represents multiple priorities, time management, prioritization, and adaptability. This card suggests managing multiple priorities and adapting.',
                'card_content_reversed' => 'The Two of Pentacles reversed suggests over-committed, disorganization, reprioritization, and reprioritizing. It indicates being over-committed or disorganized.',
                'card_position' => 66
            ),
            array(
                'card_name' => 'Three of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Three of Pentacles represents teamwork, collaboration, building, and learning. This card suggests teamwork and collaboration.',
                'card_content_reversed' => 'The Three of Pentacles reversed suggests disharmony, misalignment, working alone, and conflict. It indicates disharmony or working alone.',
                'card_position' => 67
            ),
            array(
                'card_name' => 'Four of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Four of Pentacles represents saving money, security, conservatism, and protection. This card suggests saving money and financial security.',
                'card_content_reversed' => 'The Four of Pentacles reversed suggests greed, self-protection, giving, and generosity. It indicates greed or generosity.',
                'card_position' => 68
            ),
            array(
                'card_name' => 'Five of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Five of Pentacles represents financial loss, poverty, lack mindset, isolation, and worry. This card suggests financial loss and worry.',
                'card_content_reversed' => 'The Five of Pentacles reversed suggests recovery, charity, improvement, and spirituality. It indicates recovery or charity.',
                'card_position' => 69
            ),
            array(
                'card_name' => 'Six of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Six of Pentacles represents generosity, sharing, giving, prosperity, and charity. This card suggests generosity and sharing.',
                'card_content_reversed' => 'The Six of Pentacles reversed suggests self-protection, self-interest, hoarding, and stinginess. It indicates self-protection or stinginess.',
                'card_position' => 70
            ),
            array(
                'card_name' => 'Seven of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Seven of Pentacles represents hard work, perseverance, diligence, and patience. This card suggests hard work and patience.',
                'card_content_reversed' => 'The Seven of Pentacles reversed suggests work without results, distractions, lack of long-term vision, and impatience. It indicates work without results or impatience.',
                'card_position' => 71
            ),
            array(
                'card_name' => 'Eight of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Eight of Pentacles represents mastery, skill development, diligence, and high standards. This card suggests developing skills and mastery.',
                'card_content_reversed' => 'The Eight of Pentacles reversed suggests self-development, perfectionism, ambition, and high standards. It indicates self-development or perfectionism.',
                'card_position' => 72
            ),
            array(
                'card_name' => 'Nine of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Nine of Pentacles represents luxury, self-sufficiency, financial independence, and abundance. This card suggests luxury and financial independence.',
                'card_content_reversed' => 'The Nine of Pentacles reversed suggests self-worth, over-investment in work, hustling, and financial success. It indicates self-worth or over-investment in work.',
                'card_position' => 73
            ),
            array(
                'card_name' => 'Ten of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Ten of Pentacles represents financial security, family, long-term success, and contribution. This card suggests financial security and family.',
                'card_content_reversed' => 'The Ten of Pentacles reversed suggests family disputes, lost family traditions, and short-term thinking. It indicates family disputes or lost traditions.',
                'card_position' => 74
            ),
            array(
                'card_name' => 'Page of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Page of Pentacles represents ambition, desire, diligence, and new opportunities. This card suggests ambition and new opportunities.',
                'card_content_reversed' => 'The Page of Pentacles reversed suggests lack of progress, procrastination, learn from failure, and self-development. It indicates lack of progress or procrastination.',
                'card_position' => 75
            ),
            array(
                'card_name' => 'Knight of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Knight of Pentacles represents hard work, productivity, routine, and conservatism. This card suggests hard work and productivity.',
                'card_content_reversed' => 'The Knight of Pentacles reversed suggests self-discipline, boredom, feeling stuck, perfectionism, and being workaholic. It indicates self-discipline or feeling stuck.',
                'card_position' => 76
            ),
            array(
                'card_name' => 'Queen of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The Queen of Pentacles represents nurturing, practical, providing financially, and a working parent. This card suggests nurturing and practical support.',
                'card_content_reversed' => 'The Queen of Pentacles reversed suggests self-care, self-worth, self-respect, and work-home conflict. It indicates self-care or work-home conflict.',
                'card_position' => 77
            ),
            array(
                'card_name' => 'King of Pentacles',
                'card_image' => TAROT_PLUGIN_URL . 'assets/images/cards/placeholder.svg',
                'card_content' => 'The King of Pentacles represents abundance, prosperity, security, discipline, and confidence. This card suggests abundance and prosperity.',
                'card_content_reversed' => 'The King of Pentacles reversed suggests self-discipline, boredom, feeling stuck, perfectionism, and being workaholic. It indicates self-discipline or feeling stuck.',
                'card_position' => 78
            )
        );
    }
} 