import { Card, CardContent, Typography } from '@mui/material'
import { useRouter } from 'next/router'

type ArticleCardProps = {
  title: string
  content: string
}

const omit = (text: string) => (len: number) => (ellipsis: string) =>
  text.length >= len ? text.slice(0, len - ellipsis.length) + ellipsis : text

const ArticleCard = (props: ArticleCardProps) => {
  const router = useRouter()

  // タイトルクリックでルーティング
  const handleClick = () => {
    router.push('/')
  }

  return (
    <Card sx={{ backgroundColor: 'lightblue' }}>
      <CardContent>
        <Typography
          component="div"
          onClick={handleClick}
          sx={{
            mb: 2,
            minHeight: 48,
            fontSize: 16,
            fontWeight: 'bold',
            lineHeight: 1.5,
            cursor: 'pointer',
            color: 'inherit',
            '&:hover': {
              textDecoration: 'underline',
            },
          }}
        >
          {omit(props.title)(45)('...')}
        </Typography>
        <Typography sx={{ fontSize: 12 }}>{props.content}</Typography>
      </CardContent>
    </Card>
  )
}

export default ArticleCard
